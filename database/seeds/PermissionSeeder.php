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
      Permission::create(['name' => 'Melihat daftar pengguna'])->assignRole('admin');
      Permission::create(['name' => 'Melihat detail pengguna'])->assignRole('admin');
      Permission::create(['name' => 'Menghapus pengguna'])->assignRole('admin');
      Permission::create(['name' => 'Mengubah data pengguna'])->assignRole('admin');
      Permission::create(['name' => 'Menambah pengguna'])->assignRole('admin');
      Permission::create(['name' => 'Melihat daftar role'])->assignRole('admin');
      Permission::create(['name' => 'Menambah role'])->assignRole('admin');
      Permission::create(['name' => 'Menghapus role'])->assignRole('admin');
      Permission::create(['name' => 'Mengubah data role'])->assignRole('admin');
      Permission::create(['name' => 'Melihat daftar Hak Akses'])->assignRole('admin');
    }
  }
