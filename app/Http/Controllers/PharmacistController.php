<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\User;
use App\Models\Pharmacy;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\SvgResponse;

class PharmacistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-searchprescription|create-pharmacists|edit-pharmacists|delete-pharmacists', ['only' => ['index', 'show']]);
    }

    public function index(): View
    {
        return view('Pharmacists.index');
    }

    public function store(Request $request): RedirectResponse|View
    {
        $request->validate([
            'prescription_number' => 'required|numeric',
        ]);

        $prescription = Prescription::where('prescription_number', $request->prescription_number)->first();

        if ($prescription) {
            $user2 = User::where('name', $prescription->doctor_name)->first();
            if ($user2) {
                $Pharmacy = Pharmacy::where('user_id', $user2->id)->first();

                $medications = Medication::where('prescription_id', $prescription->id)
                    ->where('created_at', $prescription->created_at)
                    ->get();

                return view('Pharmacists.result', [
                    'doctor' => $prescription,
                    'prescriptions' => $prescription,
                    'medications' => $medications,
                    'Pharmacy' => $Pharmacy
                ]);
            } else {
                return redirect()->back()->withErrors(['prescription_number' => 'Doctor not found.']);
            }
        } else {
            return redirect()->back()->withErrors(['prescription_number' => 'Prescription not found.']);
        }
    }

}
