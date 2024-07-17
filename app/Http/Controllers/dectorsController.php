<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class dectorsController extends Controller
{
    /**
     * Instantiate a new dectorsController instance.
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
    public function index(): View
    {
        $patients = User::whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->latest('id')->paginate(3);
        return view('dectors.index', [
            'users' => $patients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {   $doctor=Auth::User('email');
        
        return view('dectors.create', [
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

        $dector = User::create($input);
        $dector->assignRole($request->roles);

        return redirect()->route('dectors.index')
            ->withSuccess('New dector is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $dector): view
    {
        return view('dectors.show', [
            'users' => $dector
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

        return view('dectors.edit', [
            'dector' => $dector,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $dector->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $dector): RedirectResponse
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

}
