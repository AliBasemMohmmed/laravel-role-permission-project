<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user',
            'create-dector',
            'edit-dector',
            'delete-dector',
            'create-product',
            'edit-product',
            'delete-product',
            'view-description',
            'view-prescription',
            'view-searchprescription',
            'view-product',
            'view-patient',
            'view-pharmacy',
            'view-profile',
            'create-profile',
            'edit-profile',
            'delete-profile',
            'edit-settings',
            'create-settings',
            'view-settings',

        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
