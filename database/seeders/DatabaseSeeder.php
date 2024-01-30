<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view-customers']);
        Permission::create(['name' => 'create-customers']);
        Permission::create(['name' => 'edit-customers']);
        Permission::create(['name' => 'delete-customers']);
        Permission::create(['name' => 'publish-customers']);

        Role::create(['name' => 'customer'])
            ->givePermissionTo(['view-customers', 'create-customers', 'edit-customers']);
        $admin = Role::create(['name' => 'admin']);

        $permissions = Permission::all();
        $admin->syncPermissions($permissions);

       $user = User::create([
            'name' => 'Abdurrahman',
            'email' => 'abdurrahmanekecik@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole($admin);

    }
}
