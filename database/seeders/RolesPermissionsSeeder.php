<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (Role::defaultAdminPermissions() as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        // admin role / permissions
        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());

        // user role / permissions
        Role::create(['name' => 'user'])->givePermissionTo(Role::defaultUserPermissions());
    }
}
