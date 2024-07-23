<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $productManager = Role::create(['name' => 'Product Manager']);
        $user = Role::create(['name' => 'User']);
        $doctor = Role::create(['name' => 'Doctor']);
        $pharmacists = Role::create(['name' => 'Pharmacists']);


        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            'create-product',
            'edit-product',
            'delete-product'
        ]);

        $productManager->givePermissionTo([
            'create-product',
            'edit-product',
            'delete-product'
        ]);

        $user->givePermissionTo([
            'view-prescription'
        ]);

        $doctor->givePermissionTo([
            'create-dector',
            'edit-dector',
            'delete-dector',
            'view-prescription',
            'view-product',
            'view-profile',
            'create-profile',
            'edit-profile',
            'delete-profile',
            'edit-settings',
            'create-settings',
            'view-settings',
        ]);

        $pharmacists->givePermissionTo([
            'view-searchprescription',
            'view-product',
            'view-patient',
            'view-pharmacy',
        ]);

        // $doctor->givePermissionTo([
        //     'view-product'
        // ]);
    }
}
