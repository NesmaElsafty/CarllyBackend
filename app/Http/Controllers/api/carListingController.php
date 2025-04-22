<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCarResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ImageResource;
use App\Models\allUsersModel;
use App\Models\Image;
use App\Models\carListingModel;
use Exception;
use Illuminate\Http\Request;
use Storage;
use App\Models\Package;
use App\Models\UserPackageSubscription;

class carListingController extends Controller
{
    public function getCarListing()
    {

        $data = carListingModel::orderBy('id', 'desc')->get();
        if ($data->count() > 0) {
            return response()->json([
                "status" => true,
                "data"   => $data,
            ], 200);
        } else {
            return response()->json([
                "status"  => false,
                "Message" => "Records is Empty",
            ], 404);
        }
    }

    ///////// add car listing
    public function addCarListing(Request $request)
    { 
        $user = auth()->user();
        $limit = $user->currentSubscription;

        if($limit != null){
            $limit = $user->currentSubscription?->package?->limits;
            if($limit != Null){
                $cars = count($user->cars);
                if($cars >= $limit){
                    return response()->json([
                        "status"  => false,
                        "message" => "You have reached the maximum number of cars allowed in your subscription plan.",
                    ]);
                }
            }
        }else{
            $package = Package::where('provider', 'Car Provider')->first();

        // إنهاء أي اشتراك حالي
        UserPackageSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->update([
                'status' => 'expired',
                'ends_at' => now(),
            ]);

        $start = now();
        if($package->period_type == 'Years'){
            $period = $package->period * 12;
            $end = $start->copy()->addMonths($period);
        }else{
            $end = $start->copy()->addMonths($package->period);
        }

        $subscription = UserPackageSubscription::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'price' => $package->price,
            'starts_at' => $start,
            'ends_at' => $end,
            'status' => 'active',
            'renewed' => false,
        ]);
        }
        $validatedData = $request->validate([
            // "listing_title" => "required",
            "listing_type"  => "required",
            "listing_model" => "required",
            "listing_year"  => "required",
            "listing_price" => "required|gt:0",
        ]);
        $user = auth()->user();
        $validatedData += [
            'listing_title'         => $request->listing_type . ' ' . $request->listing_model,
            'listing_desc'          => $request->listing_desc,
            'user_id'               => $user->id,
            'features_gear'         => $request->features_gear,
            'features_speed'        => $request->features_speed,
            'features_seats'        => $request->features_seats,
            'features_door'         => $request->features_door,
            'features_fuel_type'    => $request->features_fuel_type,
            'features_climate_zone' => $request->features_climate_zone,
            'features_cylinders'    => $request->features_cylinders,
            'features_bluetooth'    => $request->features_bluetooth,
            'features_others'       => $request->features_others,
            'car_color'             => $request->car_color,
            'location'              => $request->location ?? $user->location,
            'city'                  => $request->city ?? $user->city,
            'lat'                   => $request->lat ?? $user->lat,
            'lng'                   => $request->lng ?? $user->lng,
            'body_type'             => $request->body_type ?: '',
            'regional_specs'        => $request->regional_specs ?: '',
            'contact_number'        => $request->contact_number ?: '',
            'wa_number'             => $request->wa_number ?: '',
            'vin_number'            => $request->vin_number ?: '',
            'max'                   => 10,
        ];
        if ($request->pickup_date) {
            $validatedData['pickup_date'] = $request->pickup_date;
        }
        if ($request->pickup_time) {
            $validatedData['pickup_time'] = $request->pickup_time;
        }
        $data = carListingModel::create($validatedData);

        // upload images
        if ($request->images) {
            $uploadedImages = $request->images;

            foreach ($uploadedImages as $index => $uploadedImage) {
                if ($index >= $data->max) {
                    break;
                }

                $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();

                $path = Storage::disk('r2')->put('listings/' . $imgName, file_get_contents($uploadedImage));

                // $uploadedImage->move(public_path('listings'), $imgName);
                $imagePath = 'listings/' . $imgName;

                $data->images()->create([
                    'image' => $imagePath,
                ]);
            }
            $data->current = count($data->images);
            $data->save();
        }

        if ($data) {
            return response()->json([
                "status"  => true,
                "message" => 'Listing Successfully',
                "data"    => new UserCarResource($data),
            ], 200);
        } else {
            return response()->json([
                "status"  => false,
                "message" => "Car Listing Faild",
            ], 404);
        }

    }

    public function editCarListing(Request $request)
    {
        $data = carListingModel::findOrFail($request->carId);

        $validatedData = $request->validate([
            "listing_title" => "required",
            "listing_type"  => "required",
            "listing_model" => "required",
            "listing_year"  => "required",
            "listing_price" => "required|gt:0",
        ]);
        
        $validatedData += [
            'user_id'               => auth()->user()->id,
            'listing_desc'          => $request->listing_desc,
            'features_gear'         => $request->features_gear,
            'features_speed'        => $request->features_speed,
            'features_seats'        => $request->features_seats,
            'features_door'         => $request->features_door,
            'features_fuel_type'    => $request->features_fuel_type,
            'features_climate_zone' => $request->features_climate_zone,
            'features_cylinders'    => $request->features_cylinders,
            'features_bluetooth'    => $request->features_bluetooth,
            'features_others'       => $request->features_others,
            'car_color'             => $request->car_color,
            'location'              => $request->location ?? $data->location,
            'city'                  => $request->city ?? $data->city,
            'lat'                   => $request->lat ?? $data->lat,
            'lng'                   => $request->lng ?? $data->lng,
            'body_type'             => $request->body_type,
            'regional_specs'        => $request->regional_specs,
            'contact_number'        => $request->contact_number,
            'wa_number'             => $request->wa_number,
            'vin_number'            => $request->vin_number,
        ];
        if ($request->pickup_date) {
            $validatedData['pickup_date'] = $request->pickup_date;
        }
        if ($request->pickup_time) {
            $validatedData['pickup_time'] = $request->pickup_time;
        }

        $data->update($validatedData);
        if ($data) {
            return response()->json([
                "status"  => true,
                "message" => 'Car data updated Successfully',
            ], 200);
        } else {
            return response()->json([
                "status"  => false,
                "message" => "Car update Faild",
            ], 404);
        }

    }

    public function uploadImgs(Request $request)
    {
        try {
            $request->validate([
                'car_id'    => 'required',
                'images.*' => 'image|mimes:jpg,jpeg,png,gif',
            ]);
            $data = carListingModel::findOrFail($request->car_id);
            if ($data->current + count($request->images) > $data->max) {

                return response()->json([
                    'status'  => false,
                    'message' => "You can't upload more than " . $data->max . " images!",
                ]);
            } else {
                foreach ($request->images as $index => $uploadedImage) {

                    $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();
                    $path = Storage::disk('r2')->put('listings/' . $imgName, file_get_contents($uploadedImage));   

                    // $uploadedImage->move(public_path('listings'), $imgName);
                    $imagePath = 'listings/' . $imgName;

                    $data->images()->create([
                        'image' => $imagePath,
                    ]);

                    $data->current = $data->current + 1;
                    $data->save();
                }

                return response()->json([
                    'status'  => true,
                    'message' => "Images uploaded successfully!",
                    'data'    => ImageResource::collection($data->images),
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function myCarsListing(Request $request)
    {
        $carListings = carListingModel::with('user')->where('user_id', auth()->user()->id)->latest('id');

        if (isset($request->carType) && $request->carType != 'All') {
            $carListings->where('car_type', $request->carType);
        }
        if (isset($request->priceFrom) && $request->priceFrom != 0) {
            $carListings->where('listing_price', '>=', $request->priceFrom);
        }
        if (isset($request->priceTo) && $request->priceTo != 0) {
            $carListings->where('listing_price', '<=', $request->priceTo);
        }
        $carListings = $carListings->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "cars"       => UserCarResource::collection($carListings),
                "pagination" => [
                    'current_page' => $carListings->currentPage(),
                    'per_page'     => $carListings->perPage(),
                    'total'        => $carListings->total(),
                    'last_page'    => $carListings->lastPage(),
                ],
            ],
        ];
    }

    public function delCar(Request $request)
    {
        carListingModel::findOrFail($request->list_id)->delete();

        return [
            'status'  => true,
            'message' => "Car is removed from list successfully!",
            'data'    => null,
        ];
    }

    public function delImg($id)
    {
        try {
            $img = Image::findOrFail($id);
    
            $path = $img->image; // استخدم المسار النسبي داخل الـ bucket فقط
    
            if (Storage::disk('r2')->exists($path)) {
                Storage::disk('r2')->delete($path);
            }
    
            $data = carListingModel::findOrFail($img->carlisting_id);
            $data->current = $data->current - 1;
            $data->save();
    
            $img->delete();
    
            return [
                'status'  => true,
                'message' => "Image is removed from list and filesystem successfully!",
                'data'    => null,
            ];
        } catch (Exception $e) {
            return [
                'status'  => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getCarListingById($id)
    {
        // Find the car listing by ID and load the related user
        $carListing = carListingModel::with('user')->find($id);

        if ($carListing) {
            return response()->json([
                "status" => true,
                "data"   => $carListing, // Car listing with user information
            ], 200);
        } else {
            return response()->json([
                "status"  => false,
                "message" => "Car listing not found",
            ], 404);
        }
    }

    // Function to get a spare part by ID
    public function getSparePartsById($id)
    {
        // Find the user in `allUsersModel` by ID and load the `dealer` relationship
        $user = allUsersModel::with('dealer')->find($id);

        if ($user) {
            return response()->json([
                "status" => true,
                "user"   => $user, // Return the user data with the `dealer` relationship
            ], 200);
        } else {
            return response()->json([
                "status"  => false,
                "message" => "User not found",
            ], 404);
        }
    }

}
