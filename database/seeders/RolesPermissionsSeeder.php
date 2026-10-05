<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Content
            'view dashboard',
            'manage sliders',
            'manage news',
            'manage projects',
            'manage tenders',
            'manage vacancies',
            'manage documents',
            'manage gallery',
            'manage feedback',
            'manage leadership',
            'manage departments',
            'manage services',
            'manage pages',
            // Admin
            'manage users',
            'manage roles',
            'manage settings',
            'view audit logs',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Super Administrator — all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Administrator', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // Content Manager
        $contentManager = Role::firstOrCreate(['name' => 'Content Manager', 'guard_name' => 'web']);
        $contentManager->syncPermissions([
            'view dashboard', 'manage news', 'manage documents',
            'manage gallery', 'manage pages',
        ]);

        // Department Editor
        $deptEditor = Role::firstOrCreate(['name' => 'Department Editor', 'guard_name' => 'web']);
        $deptEditor->syncPermissions([
            'view dashboard', 'manage news', 'manage documents',
        ]);

        // Communications Officer
        $commsOfficer = Role::firstOrCreate(['name' => 'Communications Officer', 'guard_name' => 'web']);
        $commsOfficer->syncPermissions([
            'view dashboard', 'manage sliders', 'manage news',
            'manage gallery', 'manage pages',
        ]);

        // Reviewer / Approver
        $reviewer = Role::firstOrCreate(['name' => 'Reviewer', 'guard_name' => 'web']);
        $reviewer->syncPermissions(['view dashboard', 'manage news']);

        $this->command->info('Roles and permissions seeded.');
    }
}
