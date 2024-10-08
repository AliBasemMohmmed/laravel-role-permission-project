<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Javed Ur Rehman',
            'gender' => 'male',
            'email' => 'javed@allphptricks.com',
            'password' => Hash::make('javed1234')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Syed Ahsan Kamal',
            'gender' => 'male',
            'email' => 'ahsan@allphptricks.com',
            'password' => Hash::make('ahsan1234')
        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $productManager = User::create([
            'name' => 'Abdul Muqeet',
            'gender' => 'male',
            'email' => 'muqeet@allphptricks.com',
            'password' => Hash::make('muqeet1234')
        ]);
        $productManager->assignRole('Product Manager');

        // Creating Application User
        $user = User::create([
            'name' => 'Naghman Ali',
            'gender' => 'male',
            'email' => 'naghman@allphptricks.com',
            'password' => Hash::make('naghman1234')
        ]);
        $user->assignRole('User');

        $doctor = User::create([
            'name' => 'Ali basem',
            'gender' => 'male',
            'email' => 'Doctor@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $doctor->assignRole('Doctor');

        $pharmacists = User::create([
            'name' => 'Ali basem',
            'gender' => 'male',
            'email' => 'Pharmacists@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $pharmacists->assignRole('Pharmacists');
    }
}
