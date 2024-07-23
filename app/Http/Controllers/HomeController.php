<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Retrieve the number of visits, pharmacies, and different user roles
        $numberOfVisits = 50;
        $numberOfPharmacies = Pharmacy::count();
        $numberOfUsers = [
            'superAdmin' => 30,
            'Admin' => 20,
            'Doctor' => 10,
            'productManager' => 15,
            'patient' => 40,
        ];

        // Fetch user growth data grouped by day
        $userGrowthData = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('count', 'day');

        // Convert data to arrays for Chart.js
        $userGrowthLabels = $userGrowthData->keys()->toArray();
        $userGrowthData = $userGrowthData->values()->toArray();

        // Fetch sign-up growth data similarly grouped by day
        $signUpGrowthData = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('count', 'day');

        $signUpGrowthLabels = $signUpGrowthData->keys()->toArray();
        $signUpGrowthData = $signUpGrowthData->values()->toArray();

        return view('home', compact(
            'numberOfVisits',
            'numberOfPharmacies',
            'numberOfUsers',
            'userGrowthLabels',
            'userGrowthData',
            'signUpGrowthLabels',
            'signUpGrowthData'
        ));
    }
}
