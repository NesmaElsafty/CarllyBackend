<?php
namespace App\Providers;

use App\Models\allUsersModel;
use App\Models\Package;
use App\Models\UserPackageSubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

// use DB;
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
//1st
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

//2nd
        // $workshop_providers = WorkshopProvider::get();
        // foreach($workshop_providers as $provider){
        //     $provider->current = count($provider->images);
        //     $provider->max = 5;
        //     $provider->save();
        // }

//3rd
        // $package_ws = Package::where('title', 'free Workshop Provider')->first();
        // $package_cd = Package::where('title', 'free Car Provider')->first();
        // $package_sp = Package::where('title', 'free Spare Part Provider')->first();

        // $allPackages = [
        //     'dealer'            => $package_cd,
        //     'user'              => $package_cd,
        //     'shop_dealer'       => $package_sp,
        //     'workshop_provider' => $package_ws,
        // ];

        // $now = now();

        // $dealers = AllUsersModel::whereIn('usertype', array_keys($allPackages))->get();

        // $subscriptions = $dealers->map(function ($dealer) use ($allPackages, $now) {
        //     $package = $allPackages[$dealer->usertype] ?? null;

        //     if (! $package) {
        //         return null;
        //     }

        //     return [
        //         'package_id' => $package->id,
        //         'user_id'    => $dealer->id,
        //         'price'      => $package->price,
        //         'starts_at'  => $now,
        //         'ends_at'    => $now->copy()->addMonth($package->period),
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ];
        // })->filter()->values()->toArray();

        // UserPackageSubscription::insert($subscriptions);

        // $duplicates = DB::table('user_package_subscriptions')
        //     ->select('user_id')
        //     ->groupBy('user_id')
        //     ->havingRaw('COUNT(*) > 1')
        //     ->pluck('user_id');

        // DB::statement("
        //     DELETE FROM user_package_subscriptions
        //     WHERE id NOT IN (
        //         SELECT max_id FROM (
        //             SELECT MAX(id) as max_id
        //             FROM user_package_subscriptions
        //             GROUP BY user_id
        //         ) as keep_ids
        //     )
        // ");
    }
}
