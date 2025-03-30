<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\allUsersModel;
use App\Models\carListingModel;
use Illuminate\Http\Request;
use Exception;
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
    // dd('adhkjsdkh');
        $validatedData = $request->validate([
            "listing_title" => "required",
            "listing_type"  => "required",
            "listing_model" => "required",
            "listing_year"  => "required",
            "listing_price" => "required|gt:0",
        ]);
        ////////// handle images start
        $listingImages = ['listing_img1', 'listing_img2', 'listing_img3', 'listing_img4', 'listing_img5'];

        // Define the base URL to be removed
        $baseUrl = env('APP_URL');

        foreach ($listingImages as $key => $imgField) {
            // Check if it's a file or a URL string
            if ($request->hasFile($imgField)) {
                // Handle file upload
                $img     = $request->file($imgField);
                $imgName = time() . ($key + 1) . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('listings'), $imgName);
                $listingImgPath           = 'listings/' . $imgName;
                $validatedData[$imgField] = $listingImgPath;
            } elseif ($request->filled($imgField) && filter_var($request->input($imgField), FILTER_VALIDATE_URL)) {
                // Handle custom direct link (URL)
                $imgUrl = $request->input($imgField);

                // Remove the base URL from the image link
                if (strpos($imgUrl, $baseUrl) === 0) {
                    $imgUrl = str_replace($baseUrl, '', $imgUrl);
                }

                // Store the remaining part of the URL
                $validatedData[$imgField] = $imgUrl;
            } else {
                                                                            // Leave unchanged or set empty if needed
                $validatedData[$imgField] = $existingData[$imgField] ?? ''; // Assuming you have previous data stored
            }
        }

        $validatedData += [
            'listing_desc'          => $request->listing_desc,
            'user_id'               => auth()->user()->id,
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
            'location'              => $request->location,
            'city'                  => $request->city ?: '',
            'lat'                   => $request->lat ?: '',
            'lng'                   => $request->lng ?: '',
            'body_type'             => $request->body_type ?: '',
            'regional_specs'        => $request->regional_specs ?: '',
            'contact_number'        => $request->contact_number ?: '',
            'wa_number'             => $request->wa_number ?: '',
            'vin_number'            => $request->vin_number ?: '',
        ];
        if ($request->pickup_date) {
            $validatedData['pickup_date'] = $request->pickup_date;
        }
        if ($request->pickup_time) {
            $validatedData['pickup_time'] = $request->pickup_time;
        }
        // dd($validatedData);
        $data = carListingModel::create($validatedData);
        if ($data) {
            return response()->json([
                "status"  => true,
                "message" => 'Listing Successfully',
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

        $validatedData = $request->validate([
            "listing_title" => "required",
            "listing_type"  => "required",
            "listing_model" => "required",
            "listing_year"  => "required",
            "listing_price" => "required|gt:0",
        ]);
        $listingImages = ['listing_img1', 'listing_img2', 'listing_img3', 'listing_img4', 'listing_img5'];

        // Define the base URL to be removed
        $baseUrl = env('APP_URL');

        foreach ($listingImages as $key => $imgField) {
            // Check if it's a file or a URL string
            if ($request->hasFile($imgField)) {
                // Handle file upload
                $img     = $request->file($imgField);
                $imgName = time() . ($key + 1) . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('listings'), $imgName);
                $listingImgPath           = 'listings/' . $imgName;
                $validatedData[$imgField] = $listingImgPath;
            } elseif ($request->filled($imgField) && filter_var($request->input($imgField), FILTER_VALIDATE_URL)) {
                // Handle custom direct link (URL)
                $imgUrl = $request->input($imgField);

                // Remove the base URL from the image link
                if (strpos($imgUrl, $baseUrl) === 0) {
                    $imgUrl = str_replace($baseUrl, '', $imgUrl);
                }

                // Store the remaining part of the URL
                $validatedData[$imgField] = $imgUrl;
            } else {
                                                                            // Leave unchanged or set empty if needed
                $validatedData[$imgField] = $existingData[$imgField] ?? ''; // Assuming you have previous data stored
            }
        }

        $validatedData += [
            'listing_desc'          => $request->listing_desc,
            'user_id'               => auth()->user()->id,
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
            'location'              => $request->location,
            'city'                  => $request->city ?: '',
            'lat'                   => $request->lat ?: '',
            'lng'                   => $request->lng ?: '',
            'body_type'             => $request->body_type ?: '',
            'regional_specs'        => $request->regional_specs ?: '',
            'contact_number'        => $request->contact_number ?: '',
            'wa_number'             => $request->wa_number ?: '',
            'vin_number'            => $request->vin_number ?: '',
        ];
        if ($request->pickup_date) {
            $validatedData['pickup_date'] = $request->pickup_date;
        }
        if ($request->pickup_time) {
            $validatedData['pickup_time'] = $request->pickup_time;
        }
        // dd($validatedData);
        $data = carListingModel::findOrFail($request->carId)->update($validatedData);
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
        try{
            $listingImages = ['listing_img1', 'listing_img2', 'listing_img3', 'listing_img4', 'listing_img5'];
            $baseUrl = 'https://livebackend.carllymotors.com';
            $car = CarListingModel::find($request->car_id);
    
            foreach ($request->imgs as $key => $img) {
                $imgStr = 'listing_img' . ($key + 1); 
                // Check if it's a file or a URL string
                    // Handle file upload
                    $imgName = time() . ($key + 1) . '.' . $img->getClientOriginalExtension();
                    $img->move(public_path('listings'), $imgName);
                    $listingImgPath           = 'listings/' . $imgName;
                    // Assign the file to that property using curly braces
                    
                    $car->{$imgStr} = $listingImgPath;
                    $car->save();
            }
            return response()->json([
                "status"  => true,
                "message" => 'Images uploaded Successfully',
            ], 200);
        }catch(Exception $e){
            return response()->json([
                "status"  => false,
                "message" => "Faild to upload imgs",
                "error" => $e->getMessage(),
            ], 500);
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
                "cars"       => $carListings->items(),
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