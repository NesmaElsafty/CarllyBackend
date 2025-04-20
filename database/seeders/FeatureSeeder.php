<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;
use Illuminate\Support\Str;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        // Or generate 10 random ones using Faker
        $features = array('free','premium', 'featured', 'car_of_the_week', 'normal');
        foreach($features as $feature){
            $feat = new Feature();
            $feat->name = $feature;
            $feat->save();
        }
    }
}
