<?php

namespace App\Providers;
use App\Models\carListingModel;
use App\Models\WorkshopProvider;
use App\Models\Image;
use Illuminate\Support\ServiceProvider;
use DB;
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
        // $fields = ['listing_img1', 'listing_img2', 'listing_img3', 'listing_img4', 'listing_img5'];
        
        // foreach ($cars as $car) {
        //     foreach ($fields as $field) {
        //         if (!is_null($car->$field) && trim($car->$field) !== '') {
        //             Image::create([
        //                 'carlisting_id' => $car->id,
        //                 'image' => $car->$field,
        //             ]);  
        //         }              
        //     }
        // }

        
        // $duplicates = DB::table('images')
        // ->select('carlisting_id', 'image', DB::raw('MIN(id) as keep_id'))
        // ->groupBy('carlisting_id', 'image');

        // $idsToKeep = $duplicates->pluck('keep_id')->toArray();

        // DB::table('images')
        // ->whereNotIn('id', $idsToKeep)
        // ->delete();


        // $cars = carListingModel::get();
        // foreach($cars as $car){
        //     $car->current = count($car->images);
        //     $car->max = 10;
        //     $car->save();
        // }
        
        // $workshops = DB::table('workshop_providers')->select('id')->pluck('id')->toArray();
        // foreach( $workshops as $workshop ) {

        //     for($i=0; $i < 5; $i++){
        //         $image  = new Image();
        //         $image->workshop_provider_id = $workshop;
        //         $image->save();
        //     }
        // }
        
        
        
    }
}
