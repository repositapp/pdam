<?php

namespace Database\Seeders;

use App\Models\Tagihan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tagihan::factory(9)->create();
    }
}
