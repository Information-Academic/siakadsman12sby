<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nama_depan' => 'admin',
            'nama_belakang'=>'',
            'nama_pengguna' => 'adminsman12',
            'email' => 'adminsman12@gmail.com',
            'password' => Hash::make('admin12'),
            'roles'=>'Admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
