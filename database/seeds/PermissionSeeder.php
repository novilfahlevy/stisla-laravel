<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Permission::create(['name' => 'see_dashboard'])->assignRole('admin');
      Permission::create(['name' => 'see_users'])->assignRole('admin');
      Permission::create(['name' => 'see_user'])->assignRole('admin');
      Permission::create(['name' => 'delete_user'])->assignRole('admin');
      Permission::create(['name' => 'edit_user'])->assignRole('admin');
      Permission::create(['name' => 'add_user'])->assignRole('admin');
      Permission::create(['name' => 'see_roles'])->assignRole('admin');
      Permission::create(['name' => 'add_role'])->assignRole('admin');
      Permission::create(['name' => 'delete_role'])->assignRole('admin');
      Permission::create(['name' => 'see_role_permissions'])->assignRole('admin');
      Permission::create(['name' => 'manage_role_permissions'])->assignRole('admin');
    }
  }
