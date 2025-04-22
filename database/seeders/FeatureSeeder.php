<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;
use Illuminate\Support\Str;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = array('normal','featured' ,'car_of_the_week','premium' );
        
        for($i=0; $i < count($features); $i++){
            $feat = new Feature();
            $feat->name = $features[$i];
            $feat->priority = $i;
            $feat->save();
        }

        
       
    }
}
