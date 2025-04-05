<?php
namespace App\Providers;

use App\Models\BrandModel;
use DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $cars = DB::table('carlisting')->select('id', 'listing_img1', 'listing_img2', 'listing_img3', 'listing_img4', 'listing_img5')->get();
        // $carImages = array('listing_img1', 'listing_img2', 'listing_img3', 'listing_img4', 'listing_img5');

        // foreach($cars as $car){
        //     for($i=0; $i<count($carImages); $i++){
        //         $image  = new Image();
        //         $image->carlisting_id = $car->id;
        //         $image->image = $car->{$carImages[$i]};
        //         $image->save();
        //     }
        // }

        // $workshops = DB::table('workshop_providers')->select('id')->pluck('id')->toArray();
        // foreach( $workshops as $workshop ) {
        //     for($i=0; $i < 5; $i++){
        //         $image  = new Image();
        //         $image->workshop_provider_id = $workshop;
        //         $image->save();
        //     }
        // }

        $spareparts = DB::table('spare_parts')->select('id', 'car_model')->get();
        foreach ($spareparts as $part) {
            $models = json_decode($part->car_model, true);
            
            if(gettype($models) == 'array'){
            $modelIds = BrandModel::whereIn('name', $models)->pluck('id')->toArray();
                foreach($modelIds as $modelId){
                    DB::table('brand_model_spare_part')->insert([
                        'brand_model_id' => $modelId,
                        'spare_part_id' => $part->id,
                    ]);
                }
            }else{
                // dd($models);
                $models = json_decode($part->car_model, true);
                $models = json_decode($models, true);

                $modelIds = BrandModel::whereIn('name', $models)->pluck('id')->toArray();
                foreach($modelIds as $modelId){
                    DB::table('brand_model_spare_part')->insert([
                        'brand_model_id' => $modelId,
                        'spare_part_id' => $part->id,
                    ]);
                }
            }
        }

    }
}
