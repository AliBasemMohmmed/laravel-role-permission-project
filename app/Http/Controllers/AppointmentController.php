<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\View\View;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Notifications\AppointmentBooked;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-appointment|create-appointment|edit-appointment|delete-appointment', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-appointment', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-appointment', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-appointment', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $appointments = Appointment::where('patient_id', Auth::id())->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create(): View
    {
        return view('appointments.create');
    }

    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $patientId = Auth::id();

        $settings = Setting::where('user_id', $data['doctor_id'])->first();

        if (!$settings) {
            return redirect()->back()->with('error', 'Doctor settings not found.');
        }

        $appointmentsToday = Appointment::where('doctor_id', $data['doctor_id'])
            ->whereDate('appointment_date', $data['appointment_date'])
            ->count();

        if ($appointmentsToday >= $settings->daily_patient_limit) {
            return redirect()->back()->with('error', 'Doctor has reached the daily patient limit.');
        }

        $appointmentTime = now()->setTimeFromTimeString($settings->start_time)
            ->addMinutes($appointmentsToday * 30);

        $data['appointment_time'] = $appointmentTime->toTimeString();
        $data['patient_id'] = $patientId;

        $appointment = Appointment::create($data);

        $patient = Auth::user();
        $patient->notify(new AppointmentBooked($appointment));

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully.');
    }

    public function show(Appointment $appointment): View
    {
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment): View
    {
        return view('appointments.edit', compact('appointment'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $data = $request->validated();
        $appointment->update($data);
        return redirect()->route('appointments.show', $appointment->id)->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
