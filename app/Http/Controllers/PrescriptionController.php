<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\Medication;
use App\Models\Prescription;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;

class PrescriptionController extends Controller
{
    /**
     * Instantiate a new PrescriptionController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-dector|edit-dector|delete-dector', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-dector', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-dector', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-dector', ['only' => ['destroy']]);
        $this->middleware('permission:delete-dector', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(User $request): View
    {
        $patients = User::whereHas('roles', function ($query) {
            $query->where('name', 'patient');
        })->latest('id')->paginate(3);
        return view('prescriptions.index', [
            'users' => $patients
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function allprescription(User $dector): View
    {
        return view('prescriptions.allprescription', [
            'prescriptions' => $dector
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $doctor = Auth::User();
        // dd( $doctor);
        $prodect = Product::all();
        return view('prescriptions.create', [
            'roles' => Role::pluck('name')->all(),
            'prescriptions' => $prodect,
            'doctor' => $doctor
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrescriptionRequest $request): RedirectResponse
    {
        $input = $request->all();
        // إنشاء الوصفة الطبية
        $prescription = Prescription::create([
            'doctor_name' => $input['doctor_name'],
            'patient_name' => $input['patient_name'],
            'national_id_image' => $request->file('national_id_image')->store('national_id_images'),
            'patient_age' => $input['patient_age'],
            'prescription_number' => $input['prescription_number'],
            'dispensation_date' => $input['dispensation_date'],
        ]);

        // إضافة العلاجات المرتبطة بالوصفة الطبية
        foreach ($input['medication'] as $index => $medication) {
            Medication::create([
                'prescription_id' => $prescription->id,
                'medication_name' => $medication,
                'time' => $input['time'][$index],
                'eating' => $input['eating'][$index],
                'dosage_frequency' => $input['dosage_frequency'][$index],
            ]);
        }

        return redirect()->route('dectors.index')
            ->withSuccess('New prescription is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $dector)
    {
        $users =  Medication::all(); // Fetch all prescriptions

        return view('prescriptions.show', [
            'users' => $users, // Pass prescriptions data to the view
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $dector): View
    {
        // Check Only Super Admin can update his own Profile
        if ($dector->hasRole('Super Admin')) {
            if ($dector->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('prescriptions.edit', [
            'dector' => $dector,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $dector->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrescriptionRequest $request, User $dector): RedirectResponse
    {
        $input = $request->all();

        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = $request->except('password');
        }

        $dector->update($input);

        $dector->syncRoles($request->roles);

        return redirect()->back()
            ->withSuccess('User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $dector): RedirectResponse
    {
        // About if dector is Super Admin or User ID belongs to Auth User
        if ($dector->hasRole('Super Admin') || $dector->id == auth()->user()->id) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $dector->syncRoles([]);
        $dector->delete();
        return redirect()->route('dectors.index')
            ->withSuccess('User is deleted successfully.');
    }

    /**
     * Show the form for Prescription the specified resource.
     */
}
