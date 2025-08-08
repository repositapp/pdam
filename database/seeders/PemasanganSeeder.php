<?php

namespace Database\Seeders;

use App\Models\Pemasangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemasanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pemasangan::factory(9)->create();
    }
}
