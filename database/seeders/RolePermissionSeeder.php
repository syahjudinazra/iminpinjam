<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name'=>'tambah-user']);
        Permission::create(['name'=>'edit-user']);
        Permission::create(['name'=>'lihat-user']);
        Permission::create(['name'=>'hapus-user']);

        Permission::create(['name'=>'tambah-data']);
        Permission::create(['name'=>'edit-data']);
        Permission::create(['name'=>'lihat-data']);
        Permission::create(['name'=>'hapus-data']);

        Role::create(['name'=>'superadmin']);
        Role::create(['name'=>'admin']);

        $roleSuperAdmin = Role::findByName('superadmin');
        $roleSuperAdmin->givePermissionTo('tambah-user');
        $roleSuperAdmin->givePermissionTo('edit-user');
        $roleSuperAdmin->givePermissionTo('lihat-user');
        $roleSuperAdmin->givePermissionTo('hapus-user');

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('tambah-data');
        $roleAdmin->givePermissionTo('edit-data');
        $roleAdmin->givePermissionTo('lihat-data');
        $roleAdmin->givePermissionTo('hapus-data');
    }
}
