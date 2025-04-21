<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;
use App\Models\Feature;
use Illuminate\Support\Facades\DB;
class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $package = new Package();
        $package->title = 'free'; 
        $package->period = 1;
        $package->period_type = 'Months';
        $package->provider = 'Car Provider';
        $package->price = 0;
        $package->save();

        $feature = Feature::first();

        DB::table('feature_package')->insert([
            'feature_id' => $feature->id,
            'package_id' => $package->id,
        ]);
    }
}
