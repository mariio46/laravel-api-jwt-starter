<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $roles = collect(['superadmin', 'admin', 'operator', 'registrant']);

        $roles->each(fn ($role) => Role::create(['name' => $role]));

        // Permission
        $permissions = collect([
            'update full account',
            'update half account',

            'management role permission',

            'store role',
            'update role',
            'delete role',

            'store permission',
            'update permission',
            'delete permission',

            'assign user role',
            'assign role permission',

            'management registration',
            'reset registration',

            'management schedule',

            'management users',

            'view admin',
            'store admin',
            'update admin',
            'update password admin',
            'delete admin',

            'view operator',
            'store operator',
            'update operator',
            'update password operator',
            'delete operator',

            'view registrant',
            'store registrant',
            'update registrant',
            'update password registrant',
            'delete registrant',

            'update biodata',
        ]);

        $permissions->each(fn ($permission) => Permission::create(['name' => $permission]));

        // Role -> Permission
        Role::findByName(name: 'admin')->givePermissionTo([
            'update full account',

            'management registration',

            'management users',

            'view registrant',
            'store registrant',
            'update registrant',
            'update password registrant',
            'delete registrant',

            'view operator',
            'store operator',
            'update operator',
            'update password operator',
            'delete operator',
        ]);

        Role::findByName(name: 'operator')->givePermissionTo([
            'update full account',
            'management users',
            'view registrant',
            'store registrant',
            'update registrant',
        ]);

        Role::findByName(name: 'registrant')->givePermissionTo([
            'update half account',
            'update biodata',
        ]);

        // User -> Role
        User::query()->where('email', 'mariomad2296@gmail.com')->first()->assignRole('superadmin');
        User::query()->where('email', 'fitra@gmail.com')->first()->assignRole('admin');
        User::query()->where('email', 'asdar@gmail.com')->first()->assignRole('operator');
    }
}
