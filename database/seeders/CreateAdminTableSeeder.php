<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        $role = Role::create(['name' => 'Administrator', 'guard_name' => 'admin']);
        $admin = Admin::create([
           'name' => 'Administrator',
           'email' => 'admin@demo.id',
           'password' => Hash::make('Password123')
        ]);
        $admin->assignRole($role);
    }
}
