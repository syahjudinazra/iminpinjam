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

        $david = User::create([
            'name' => 'david',
            'email' => 'david@imin.co.id',
            'password' => bcrypt('iMin2020')
        ]);
        $david->assignRole('david');

        $sales = User::create([
            'name' => 'sales',
            'email' => 'sales@imin.co.id',
            'password' => bcrypt('iMin2020')
        ]);
        $sales->assignRole('sales');
    }
}
