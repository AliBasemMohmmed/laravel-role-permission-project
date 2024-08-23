<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AppointmentBooked;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-appointment|edit-appointment|delete-appointment', ['only' => [ 'show']]);
        $this->middleware('permission:view-allppointment|edit-appointment|delete-appointment', ['only' => ['index']]);
        $this->middleware('permission:create-appointment', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-appointment', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-appointment', ['only' => ['destroy']]);
    }
    public function index()
    {
        $currentWeek = $this->getCurrentWeekDates();
        $doctor = Auth::user(); // أو قد تحتاج إلى تحديد الطبيب بطرق مختلفة

        // Retrieve doctor's settings
        $settings = Setting::where('user_id', $doctor->id)->first();

        if (!$settings) {
            return redirect()->back()->with('error', 'Doctor settings not found.');
        }

        // Extract vacation days from settings
        $vacationDays = $settings->vacation_days ?? [];

        // Convert vacation days to array of dates
        $vacationDates = [];
        foreach ($vacationDays as $day) {
            $date = Carbon::parse($day)->format('Y-m-d');
            $vacationDates[] = $date;
        }

        $appointments = Appointment::whereBetween('appointment_date', [$currentWeek['start'], $currentWeek['end']])
            ->get()
            ->groupBy('appointment_date');

        return view('appointments.show', [
            'appointments' => $appointments,
            'vacationDates' => $vacationDates,
            'currentWeek' => $currentWeek,
            'doctorName' => $doctor->name,
        ]);
    }

    private function getCurrentWeekDates()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        return ['start' => $startOfWeek, 'end' => $endOfWeek];
    }
    public function book(User $doctor)
    {
        $patient = Auth::user();

        // Retrieve doctor's settings
        $settings = Setting::where('user_id', $doctor->id)->first();

        if (!$settings) {
            return redirect()->back()->with('error', 'Doctor settings not found.');
        }

        // Check if the patient is already booked for today
        if (Appointment::where('patient_id', $patient->id)
            ->whereDate('appointment_date', today())
            ->exists()
        ) {
            return redirect()->back()->with('success', 'You already have an appointment today.');
        }

        // Count today's appointments
        $appointmentsToday = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->count();

        // Check if the daily limit is reached
        if ($appointmentsToday >= $settings->daily_patient_limit) {
            // Find the next available time
            $maxDaysAhead = 30;
            $currentDate = now();
            $startTime = new \DateTime($settings->start_time);
            $endTime = new \DateTime($settings->end_time);

            for ($i = 0; $i < $maxDaysAhead; $i++) {
                $searchDate = $currentDate->copy()->addDays($i);

                // Skip vacation days
                if (in_array($searchDate->dayOfWeek, $settings->vacation_days)) {
                    continue;
                }

                // Count appointments for the search date
                $appointmentsCount = Appointment::where('doctor_id', $doctor->id)
                    ->whereDate('appointment_date', $searchDate->toDateString())
                    ->count();

                if ($appointmentsCount < $settings->daily_patient_limit) {
                    $currentReservations = Appointment::where('doctor_id', $doctor->id)
                        ->whereDate('appointment_date', $searchDate->toDateString())
                        ->pluck('appointment_time')
                        ->toArray();

                    $availableTime = clone $startTime;

                    while ($availableTime < $endTime) {
                        if (!in_array($availableTime->format('H:i:s'), $currentReservations)) {
                            // Create appointment with next available time
                            $appointment = Appointment::create([
                                'doctor_id' => $doctor->id,
                                'patient_id' => $patient->id,
                                'appointment_date' => $searchDate->toDateString(),
                                'appointment_time' => $availableTime->format('H:i:s'),
                            ]);

                            // Send notification to patient
                            // $patient->notify(new AppointmentBooked($appointment));

                            return redirect()->route('appointments.show', ['appointment' => $appointment])
                                ->with('success', 'Appointment booked successfully for ' . $searchDate->toDateString() . ' at ' . $availableTime->format('H:i:s'));
                        }
                        $availableTime->add(new \DateInterval('PT15M')); // Assuming 15 minutes per appointment
                    }
                }
            }

            return redirect()->back()->with('error', 'No available slots for booking.');
        }

        // Calculate appointment time for today
        $appointmentTime = now()->setTimeFromTimeString($settings->start_time)->addMinutes($appointmentsToday * 30); // Assuming each appointment is 30 minutes long

        // Create appointment for today
        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'appointment_date' => $appointmentTime->toDateString(),
            'appointment_time' => $appointmentTime->toTimeString(),
        ]);

        // Send notification to patient
        // $patient->notify(new AppointmentBooked($appointment));

        return redirect()->route('appointments.show', ['appointment' => $appointment])
            ->with('success', 'Appointment booked successfully for today.');
    }

    public function show(Appointment $appointment)
    {
        $doctorName = User::find($appointment->doctor_id)->name;
        return view('appointments.index', ['appointment' => $appointment, 'doctorName' => $doctorName]);
    }
}
