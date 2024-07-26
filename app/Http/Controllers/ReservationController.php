<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Setting;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-reservation', ['only' => ['index', 'edit']]);
        $this->middleware('permission:create-reservation', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-reservation', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-reservation', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $doctors = User::whereHas('roles', function ($query) {
            $query->where('name', 'doctor');
        })
        ->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('pharmacy', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('location', 'like', "%{$search}%");
                });
        })
        ->with('profile', 'pharmacy')
        ->get();

        return view('reservation.index', compact('doctors', 'search'));
    }

    public function show($id)
    {
        $doctor = User::with(['profile', 'settings'])->findOrFail($id);
        return view('reservation.show', compact('doctor'));
    }
}
