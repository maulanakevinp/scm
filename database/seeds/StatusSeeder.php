<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['keterangan' => 'Belum diproses']);
        Status::create(['keterangan' => 'Ditolak']);
        Status::create(['keterangan' => 'Sedang diproses']);
        Status::create(['keterangan' => 'Sedang dikirim']);
        Status::create(['keterangan' => 'Diterima']);
    }
}
