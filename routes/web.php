<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\dectorsController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\pharmacyController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\PrescriptionController;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resources([
    'roles' => RoleController::class,
    'pharmacy' => pharmacyController::class,
    'pharmacists' => PharmacistController::class,
    'prescription' => PrescriptionController::class,
    'dectors' => dectorsController::class,
    'users' => UserController::class,
    'products' => ProductController::class,
    'patients' => PatientController::class,
    'profiles' =>  ProfileController::class,
]);
