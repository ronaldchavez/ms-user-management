<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['create_user', 'list_user', 'update_user', 'delete_user', 'view_user'];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->where('guard_name', 'sanctum')->exists()) {
                Permission::create(['name' => $permission]);
            }    
        }

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['list_user', 'view_user']);
    }
}
