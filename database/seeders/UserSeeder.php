<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'administrator',
            'email' => 'antoniluthfi331@gmail.com',
            'password' => bcrypt('antoni123'),
            'nomorhp' => '087865226782',
            'jabatan' => 'administrator',
            'cab_penempatan' => 'Landasan Ulin',
            'status_akun' => '1',
        ]);
    }
}
