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
        Permission::create(['name' => 'tambah-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'lihat-user']);
        Permission::create(['name' => 'hapus-user']);

        Permission::create(['name' => 'tambah-data']);
        Permission::create(['name' => 'edit-data']);
        Permission::create(['name' => 'lihat-data']);
        Permission::create(['name' => 'hapus-data']);

        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'jeffri']);
        Role::create(['name' => 'maulana']);
        Role::create(['name' => 'vivi']);
        Role::create(['name' => 'sylvi']);
        Role::create(['name' => 'coni']);
        Role::create(['name' => 'david']);
        Role::create(['name' => 'sales']);
        Role::create(['name' => 'teknisi']);

        $roleSuperAdmin = Role::findByName('superadmin');
        $roleSuperAdmin->givePermissionTo('tambah-user');
        $roleSuperAdmin->givePermissionTo('edit-user');
        $roleSuperAdmin->givePermissionTo('lihat-user');
        $roleSuperAdmin->givePermissionTo('hapus-user');

        $roleJeffri = Role::findByName('jeffri');
        $roleJeffri->givePermissionTo('tambah-data');
        $roleJeffri->givePermissionTo('edit-data');
        $roleJeffri->givePermissionTo('lihat-data');
        $roleJeffri->givePermissionTo('hapus-data');

        $roleMaulana = Role::findByName('maulana');
        $roleMaulana->givePermissionTo('tambah-data');
        $roleMaulana->givePermissionTo('edit-data');
        $roleMaulana->givePermissionTo('lihat-data');
        $roleMaulana->givePermissionTo('hapus-data');

        $roleVivi = Role::findByName('vivi');
        $roleVivi->givePermissionTo('tambah-data');
        $roleVivi->givePermissionTo('edit-data');
        $roleVivi->givePermissionTo('lihat-data');
        $roleVivi->givePermissionTo('hapus-data');

        $roleSylvi = Role::findByName('sylvi');
        $roleSylvi->givePermissionTo('tambah-data');
        $roleSylvi->givePermissionTo('edit-data');
        $roleSylvi->givePermissionTo('lihat-data');
        $roleSylvi->givePermissionTo('hapus-data');

        $roleConi = Role::findByName('coni');
        $roleConi->givePermissionTo('tambah-data');
        $roleConi->givePermissionTo('edit-data');
        $roleConi->givePermissionTo('lihat-data');
        $roleConi->givePermissionTo('hapus-data');

        $roleDavid = Role::findByName('david');
        $roleDavid->givePermissionTo('tambah-data');
        $roleDavid->givePermissionTo('edit-data');
        $roleDavid->givePermissionTo('lihat-data');
        $roleDavid->givePermissionTo('hapus-data');

        $roleSales = Role::findByName('sales');
        $roleSales->givePermissionTo('lihat-data');

        $roleTeknisi = Role::findByName('teknisi');
        $roleTeknisi->givePermissionTo('lihat-data');
    }
}
