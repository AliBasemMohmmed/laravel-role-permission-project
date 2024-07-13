<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Pharmacy;
use Illuminate\View\View;
use App\Models\Medication;
use App\Models\Prescription;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class PatientController extends Controller
{
    /**
     * Instantiate a new PatientController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-prescription|edit-patient|delete-patient|profile', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user|profile', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user|profile', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user|profile', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('users.index', [
            'users' => User::latest('id')->paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create', [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $user = Auth::user()->id;
        $patient = User::where('id', $user)->first();
        $prescription = Prescription::where('patient_name', $patient->name)->first();
        $user2=User::where('name', $prescription->doctor_name)->first();
        $Pharmacy = Pharmacy::where('user_id', $user2->id)->first();
        if ($prescription) {
            $medications = Medication::where('prescription_id', $prescription->id)->first();
            return view('patient.prescription', [
                'doctor' => $prescription,
                'prescriptions' => $prescription,
                'medications' => $medications,
                'Pharmacy' =>  $Pharmacy
            ]);
        } else {
            // Handle case where no prescription is found for the patient
            // For example, redirect back or show an error message
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();

        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = $request->except('password');
        }

        $user->update($input);

        $user->syncRoles($request->roles);

        return redirect()->back()
            ->withSuccess('User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
            ->withSuccess('User is deleted successfully.');
    }
    public function profile(User $user): View
    {
        return view('Users.profile', [
            'user' => $user
        ]);
    }
}
