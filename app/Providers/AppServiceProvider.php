<?php

namespace App\Providers;
use App\Models\CarlistingModel;
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
            //         Image::create([
            //             'carlisting_id' => $car->id,
            //             'image' => $car->$field,
            //         ]);
            //     }
        
            //     for ($i = 0; $i < 5; $i++) {
            //         Image::create([
            //             'carlisting_id' => $car->id,
            //             'image' => null,
            //         ]);
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
        
        
        
    }
}
