<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pharmacy;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StorePharmacyRequest;
use App\Http\Requests\UpdatePharmacyRequest;

class PharmacyController extends Controller
{
    /**
     * Instantiate a new PharmacyController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-Pharmacy|create-Pharmacy|edit-Pharmacy|delete-Pharmacy', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-Pharmacy', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-Pharmacy', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-Pharmacy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('Pharmacys.index', [
            'Pharmacy' => Pharmacy::latest()->paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Pharmacys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePharmacyRequest $request): RedirectResponse
    {
        Pharmacy::create($request->all());
        return redirect()->route('pharmacy.index')
            ->withSuccess('New Pharmacy is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pharmacy $Pharmacy): View
    { // Example data preparation for a chart
        $pharmacyVisits = Pharmacy::orderBy('visits_count', 'desc')->take(5)->get();
        // Example logic to calculate gender ratios
        $maleCount = User::where('gender', 'male')->count();
        $femaleCount = User::where('gender', 'female')->count();
        $totalPatients = $maleCount + $femaleCount;

        return view('Pharmacys.show', [
            'Pharmacy' => $Pharmacy,
            'pharmacyVisits' => $Pharmacy,
            'maleCount' => $maleCount,
            'femaleCount' => $femaleCount,
            'totalPatients' => $totalPatients,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pharmacy $Pharmacy): View
    {
        return view('Pharmacys.edit', [
            'Pharmacy' => $Pharmacy
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePharmacyRequest $request, Pharmacy $Pharmacy): RedirectResponse
    {
        $Pharmacy->update($request->all());
        return redirect()->back()
            ->withSuccess('Pharmacy is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $Pharmacy): RedirectResponse
    {
        $Pharmacy->delete();
        return redirect()->route('pharmacy.index')
            ->withSuccess('Pharmacy is deleted successfully.');
    }
}
