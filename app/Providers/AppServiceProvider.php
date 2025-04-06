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


        // $workshop_providers = WorkshopProvider::get();
        // foreach($workshop_providers as $provider){
        //     $provider->current = count($provider->images);
        //     $provider->max = 5;
        //     $provider->save();
        // }
        

    //     DB::table('spare_parts')
    // ->select('id', 'car_model')
    // ->orderBy('id')
    // ->chunk(1000, function ($spareparts) {
    //     $insertData = [];

    //     foreach ($spareparts as $part) {
    //         $models = json_decode($part->car_model, true);

    //         if (!is_array($models)) {
    //             $models = json_decode($models, true);
    //         }

    //         if (is_array($models)) {
    //             $modelIds = BrandModel::whereIn('name', $models)->pluck('id')->toArray();

    //             foreach ($modelIds as $modelId) {
    //                 $insertData[] = [
    //                     'brand_model_id' => $modelId,
    //                     'spare_part_id' => $part->id,
    //                 ];
    //             }
    //         }
    //     }

    //     if (!empty($insertData)) {
    //         foreach (array_chunk($insertData, 1000) as $chunkedInsert) {
    //             DB::table('brand_model_spare_part')->insert($chunkedInsert);
    //         }
    //     }
    // });


    }
}
