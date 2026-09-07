<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // System Modules
        $modules = [
            'medicines',
            'categories',
            'sub_categories',
            'generics',
            'brands',
            'manufacturers',
            'batches',
            'stock',
            'pos',
            'sales',
            'sale_returns',
            'orders',
            'purchases',
            'suppliers',
            'customers',
            'doctors',
            'prescriptions',
            'employees',
            'attendances',
            'payrolls',
            'accounts',
            'expenses',
            'incomes',
            'branches',
            'reports',
            'users',
            'roles',
            'settings',
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        $allPermissions = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissionName = "{$action} {$module}";
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $allPermissions[] = $permission;
            }
        }

        // Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole      = Role::firstOrCreate(['name' => 'Admin']);
        $managerRole    = Role::firstOrCreate(['name' => 'Manager']);
        $pharmacistRole = Role::firstOrCreate(['name' => 'Pharmacist']);
        $cashierRole    = Role::firstOrCreate(['name' => 'Cashier']);
        $accountantRole = Role::firstOrCreate(['name' => 'Accountant']);
        $storeKeeperRole= Role::firstOrCreate(['name' => 'Store Keeper']);
        $branchMgrRole  = Role::firstOrCreate(['name' => 'Branch Manager']);

        // Assign all permissions to Super Admin and Admin
        $superAdminRole->syncPermissions(Permission::all());
        $adminRole->syncPermissions(Permission::all());

        // Create or sync Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@pharmacy.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole('Super Admin');
        }
    }
}
