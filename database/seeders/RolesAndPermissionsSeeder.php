<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'merchant']);

        $permission1 = Permission::create(['name' => 'create transaction']);
        $permission2 = Permission::create(['name' => 'view transactions']);
        $permission3 = Permission::create(['name' => 'create merchant']);
        $permission4 = Permission::create(['name' => 'view merchant']);

        $role1->givePermissionTo($permission1, $permission2, $permission3, $permission4);
        $role2->givePermissionTo($permission1, $permission2);
    }
}
