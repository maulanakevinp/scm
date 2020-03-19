<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'peran' => 'Pemilik'
        ]);
        Role::create([
            'peran' => 'Produsen'
        ]);
        Role::create([
            'peran' => 'Distributor'
        ]);
        Role::create([
            'peran' => 'Superadmin'
        ]);
    }
}
