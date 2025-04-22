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
        $packageNames = array('Car Provider','Spare Part Provider','workshop', 'Workshop Provider');

        foreach($packageNames as $name){
            $package = new Package();
            $package->title = 'free ' . $name; 
            $package->period = 1;
            $package->period_type = 'Months';
            $package->provider = $name;
            $package->price = 0;
            $package->save();
            
            $feature = Feature::where('name', 'normal')->first();
    
            DB::table('feature_package')->insert([
                'feature_id' => $feature->id,
                'package_id' => $package->id,
            ]);
        }

    }
}
