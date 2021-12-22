<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = \Spatie\Permission\Models\Role::where('name', 'Administrator')->first();

        foreach ($this->permissions() as $p) {
            if (Permission::where('name', $p)->count() <= 0) {
                Permission::create([
                    'name'       => $p,
                    'guard_name' => 'admin',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        $permissions = \Spatie\Permission\Models\Permission::all();


        $role->syncPermissions($permissions->pluck('id'));

        Admin::first()->assignRole('Administrator');
    }

    private function permissions()
    {
        return [
            'Client', 'Trading Account', 'Affiliate', 'Users', 'Roles', 'General Commission', 'Report Top Looser', 'Top Commission and OR Producer',
            'Top New Member Producer', 'Top Gainer', 'Last Member Transaction', 'Symbol Statistic', 'Closed Order By LQ Time', 'Affiliate Commission', 'Tree View', 'Operating Cost', 'Referral Bonus', 'Net Margin Bonus', 'Allowance', 'Performance Report'
        ];
    }

}
