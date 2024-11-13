<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::create([
            'name' => 'superadmin',
            'email' => 'syahjudinazra@gmail.com',
            'password' => bcrypt('SuperiMin22!')
        ]);
        $superAdmin->assignRole('superadmin');

        $jeffri = User::create([
            'name' => 'jeffri',
            'email' => 'jeffri@imin.co.id',
            'password' => bcrypt('iMin2022')
        ]);
        $jeffri->assignRole('jeffri');

        $maulana = User::create([
            'name' => 'maulana',
            'email' => 'maulana@imin.co.id',
            'password' => bcrypt('iMin2024')
        ]);
        $maulana->assignRole('maulana');

        $vivi = User::create([
            'name' => 'vivi',
            'email' => 'vivi@imin.co.id',
            'password' => bcrypt('iMin2021')
        ]);
        $vivi->assignRole('vivi');

        $sylvi = User::create([
            'name' => 'sylvi',
            'email' => 'sylvi@imin.co.id',
            'password' => bcrypt('iMin2023')
        ]);
        $sylvi->assignRole('sylvi');

        $coni = User::create([
            'name' => 'coni',
            'email' => 'coni@imin.co.id',
            'password' => bcrypt('iMin2023')
        ]);
        $coni->assignRole('coni');

        $dinda = User::create([
            'name' => 'dinda',
            'email' => 'dinda@imin.co.id',
            'password' => bcrypt('iMin2023')
        ]);
        $dinda->assignRole('dinda');

        $anggi = User::create([
            'name' => 'anggi',
            'email' => 'anggi@imin.co.id',
            'password' => bcrypt('#StockiMin2024')
        ]);
        $anggi->assignRole('anggi');

        $david = User::create([
            'name' => 'david',
            'email' => 'david@imin.co.id',
            'password' => bcrypt('iMin2024')
        ]);
        $david->assignRole('david');

        $sales = User::create([
            'name' => 'sales',
            'email' => 'sales@imin.co.id',
            'password' => bcrypt('iMin2020')
        ]);
        $sales->assignRole('sales');

        $chenghui = User::create([
            'name' => 'chenghui',
            'email' => 'chenghui@imin.co.id',
            'password' => bcrypt('iMin@186kit')
        ]);
        $chenghui->assignRole('chenghui');

        $teknisi = User::create([
            'name' => 'teknisi',
            'email' => 'teknisi@imin.co.id',
            'password' => bcrypt('1enamX')
        ]);
        $teknisi->assignRole('teknisi');

        $juli = User::create([
            'name' => 'juli',
            'email' => 'juli@imin.co.id',
            'password' => bcrypt('bulanjuli2024')
        ]);
        $juli->assignRole('juli');

        $matthew = User::create([
            'name' => 'matthew',
            'email' => 'matthew@imin.co.id',
            'password' => bcrypt('iMin2024')
        ]);
        $matthew->assignRole('matthew');

        $supir = User::create([
            'name' => 'supir',
            'email' => 'supir@imin.co.id',
            'password' => bcrypt('iMin2000')
        ]);
        $supir->assignRole('supir');
    }
}
