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
      Permission::create(['name' => 'see_users'])->assignRole('admin');
      Permission::create(['name' => 'see_user'])->assignRole('admin');
      Permission::create(['name' => 'delete_users'])->assignRole('admin');
      Permission::create(['name' => 'edit_users'])->assignRole('admin');
      Permission::create(['name' => 'add_users'])->assignRole('admin');
    }
  }
