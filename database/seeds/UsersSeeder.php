<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'peran'     => 1,
            'nama'      => 'Pemilik UD. Special',
            'email'     => 'pemilik@gmail.com',
            'password'  => Hash::make('12341234'),
        ]);
        User::create([
            'peran'     => 2,
            'nama'      => 'Kepala UD. Special',
            'email'     => 'kepala@gmail.com',
            'password'  => Hash::make('12341234'),
        ]);
        User::create([
            'peran'     => 3,
            'nama'      => 'Yunita',
            'email'     => 'yunita@gmail.com',
            'password'  => Hash::make('12341234'),
        ]);
        User::create([
            'peran'     => 4,
            'nama'      => 'Kevin',
            'email'     => 'kevin@gmail.com',
            'password'  => Hash::make('12341234'),
        ]);
    }
}
