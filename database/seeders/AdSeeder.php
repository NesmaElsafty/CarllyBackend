<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad; // Ensure you import the correct model

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Ad::factory()->count(15)->create();
    }
}
