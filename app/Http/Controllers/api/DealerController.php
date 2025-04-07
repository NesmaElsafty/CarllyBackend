<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarlistingResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\ShopResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WorkshopResource;
use App\Models\allUsersModel;
use App\Models\BodyType;
use App\Models\BrandModel;
use App\Models\CarBrand;
use App\Models\CarDealer;
use App\Models\Image;
use App\Models\carListingModel;
use App\Models\ModelYear;
use App\Models\RegionalSpec;
use App\Models\Setting;
use App\Models\WorkshopProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class DealerController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "email"        => 'required|email|unique:allusers,email,NULL,id,usertype,dealer',
            "phone"        => 'required|unique:allusers,phone,NULL,id,usertype,dealer',
            'fname'        => 'required',
            'password'     => 'required|min:6',
            'lat'          => 'required',
            'lng'          => 'required',
            'city'         => 'required',
            'location'     => 'required',
            'company_name' => 'required',
        ]);

        $user = allUsersModel::create([
            'fname'    => $request['fname'],
            'lname'    => $request['lname'],
            'phone'    => $request['phone'],
            'email'    => $request['email'],
            'password' => bcrypt($request['password']),
            'city'     => $request['city'] ?? '',
            'lat'      => $request['lat'] ?? '',
            'lng'      => $request['lng'] ?? '',
            'location' => $request['location'] ?? '',
            "usertype" => "dealer",
        ]);
        $cData = [
            "company_name"    => $request->company_name,
            "company_address" => $request->location,
            "user_id"         => $user->id,
        ];

        if ($request->hasFile('company_img')) {
            $img1     = $request->file('company_img');
            $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
            $img1->move(public_path('dealers'), $imgname1);
            $company_img          = 'dealers/' . $imgname1;
            $cData['company_img'] = $company_img;

        } else {
            $company_img          = 'icon/notfound.png';
            $cData['company_img'] = $company_img;
        }
        $user->update(['image' => $cData['company_img']]);

        $user->dealer = CarDealer::create($cData);

        if ($user) {
            return [
                'status'  => true,
                'message' => 'Accounted created Successfully!',
                'data'    => [
                    "auth_token"   => $user->createToken('tokens')->plainTextToken,
                    "user"         => new UserResource($user),
                    "company_data" => new ShopResource($user->dealer),
                ],
            ];
        } else {
            return [
                'status'  => false,
                'message' => 'Password is wronged!',
                'data'    => null,
            ];

        }

    }

    public function login(Request $request)
    {

        if (isset($request->firebase_auth) && $request->firebase_auth == true) {
            return $this->phoneLogin($request);
        }

        $request->validate([
            "email"    => 'required|email',
            'password' => 'required',
        ]);

        $user = allUsersModel::where(['email' => $request['email'], "userType" => "dealer"])
            ->first();
        if ($user == null) {
            return [
                'status'  => false,
                'message' => 'Email is wronged or not registered!',
                'data'    => null,
            ];
        }
        $validCredentials = Hash::check($request['password'], $user->password);
        // dd($user->password);
        if ($validCredentials) {
            return [
                'status'  => true,
                'message' => 'Login Success!',
                'data'    => [
                    "auth_token" => $user->createToken('tokens')->plainTextToken,
                    "user"       => new UserResource($user),
                ],
            ];
        } else {
            return response()->json([
                'status'  => false,
                'data'    => null,
                'message' => 'Password is wronged!',
            ], 422);
        }

    }

    public function phoneLogin(Request $request)
    {
        $request->validate([
            "phone" => 'required',
        ]);

        $user = allUsersModel::where(['phone' => $request['phone'], "userType" => "dealer"])
            ->first();

        if ($user == null) {
            return [
                'status'  => false,
                'message' => 'Phone is wronged or not registered!',
                'data'    => null,
            ];
        } else {
            return [
                'status'  => true,
                'message' => 'Login Success!',
                'data'    => [
                    "auth_token" => $user->createToken('tokens')->plainTextToken,
                    "user"       => new UserResource($user),
                ],
            ];
        }
    }

    public function logout()
    {
        // dd(auth()->user());
        auth()->user()->tokens()->delete();

        return [
            "status"  => true,
            'message' => 'You Logout successfully',
            "data"    => [],
        ];
    }

    public function getProfile(Request $request)
    {
        $user = auth()->user();
        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                'user'         => new UserResource($user),
                'company_data' => new ShopResource($user->dealer),
            ],
            // 'data' => new ShopResource($dealer),
        ];
    }
    public function getCarsListing(Request $request)
    {
        $carListings = carListingModel::with('user')->latest('id');

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
                "user"       => new UserResource(auth()->user()),
                "cars"       => CarlistingResource::collection($carListings),
                "pagination" => [
                    'current_page' => $carListings->currentPage(),
                    'per_page'     => $carListings->perPage(),
                    'total'        => $carListings->total(),
                    'last_page'    => $carListings->lastPage(),
                ],
            ],
        ];
    }

    public function addCarListing(Request $request)
    {
        $validatedData = $request->validate([
            "car_type"      => "required|in:New,Imported,Auction,Used",
            "listing_type"  => "required",
            "listing_model" => "required",
            "listing_year"  => "required",
            "listing_price" => "required|gt:0",
        ]);
        $validatedData += [
            'listing_desc'          => $request->listing_desc,
            'user_id'               => auth()->user()->id,
            'listing_title'         => $request->listing_type . ' ' . $request->listing_model,
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
            'body_type'             => $request->body_type,
            'regional_specs'        => $request->regional_specs,
            'vin_number'            => $request->vin_number,
            'wa_number'             => $request->wa_number,
            'contact_number'        => $request->contact_number,
            'max'                   => 10,
        ];

        if ($request->pickup_date) {
            $validatedData['pickup_date'] = $request->pickup_date;
        }
        if ($request->pickup_time) {
            $validatedData['pickup_time'] = $request->pickup_time;
        }

        $data = carListingModel::create($validatedData);

        if ($request->images) {
            $uploadedImages = $request->images;

            foreach ($uploadedImages as $index => $uploadedImage) {
                if ($index >= $data->max) {
                    break;
                }

                $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();
                $uploadedImage->move(public_path('listings'), $imgName);
                $imagePath = 'listings/' . $imgName;

                $data->images()->create([
                    'image' => $imagePath,
                ]);
            }
            $data->current = count($data->images);
            $data->save();
        }

        return response()->json([
            'status'  => true,
            'message' => "Car listed successfully!",
            'data'    => new CarlistingResource($data),
        ]);
    }
    public function editCarListing(Request $request)
    {
        $validatedData = $request->validate([
            "car_type"      => "required|in:New,Imported,Auction,Used",
            // "listing_title" => "required",
            "listing_type"  => "required",
            "listing_model" => "required",
            "listing_year"  => "required",
            "listing_price" => "required|gt:0",
        ]);

        $user = auth()->user();

        $validatedData += [
            'listing_desc'          => $request->listing_desc,
            'listing_title'         => $request->listing_type . ' ' . $request->listing_model,
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
            'body_type'             => $request->body_type ?: '',
            'regional_specs'        => $request->regional_specs ?: '',
            'vin_number'            => $request->vin_number ?: '',
            'wa_number'             => $request->wa_number ?? '',
            'contact_number'        => $request->contact_number ?? '',
        ];
        if ($request->auction_name) {
            $validatedData['auction_name'] = $request->auction_name;
        }
        if ($request->pickup_date) {
            $validatedData['pickup_date'] = $request->pickup_date;
        }
        if ($request->pickup_time) {
            $validatedData['pickup_time'] = $request->pickup_time;
        }
        $data = carListingModel::findOrFail($request->carId);
        $data->update($validatedData);
        return [
            'status'  => true,
            'message' => "Car list updated successfully!",
            'data'    => new CarlistingResource($data),
        ];
    }

    public function carUploadImgs(Request $request)
    {
        try {
            $request->validate([
                'carId'    => 'required',
                'images.*' => 'image|mimes:jpg,jpeg,png,gif',
            ]);
            $data = carListingModel::findOrFail($request->carId);
            if ($data->current + count($request->images) > $data->max) {

                return response()->json([
                    'status'  => false,
                    'message' => "You can't upload more than " . $data->max . " images!",
                ]);
            } else {
                foreach ($request->images as $index => $uploadedImage) {

                    $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();
                    $uploadedImage->move(public_path('listings'), $imgName);
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


    public function delImg($id)
    {
        try{
            $img = Image::findOrFail($id);

            // Get the path to the image
            $filePath = public_path($img->image); // assuming $img->image = 'uploads/cars/image.jpg'
    
            // Delete the file if it exists
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
    
            $data = carListingModel::findOrFail($img->carlisting_id);
            $data->current = $data->current - 1;
            $data->save();

            // Delete the database record
            $img->delete();
    
            return [
                'status'  => true,
                'message' => "Image is removed from list and filesystem successfully!",
                'data'    => null,
            ];
        }catch(Exception $e){
            return [
                'status'  => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function delCar(Request $request)
    {
        $car = carListingModel::findOrFail($request->list_id);
        
        foreach($car->images as $img){
            $filePath = public_path($img->image); // assuming $img->image = 'uploads/cars/image.jpg'
    
            // Delete the file if it exists
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $img->delete();
        }
        $car->delete();

        return [
            'status'  => true,
            'message' => "Car is removed from list successfully!",
            'data'    => null,
        ];
    }

    public function getBrandsList(Request $request)
    {
        $data = CarBrand::latest('id')->get();

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => $data,
        ];
    }
    public function getBrandModels(Request $request)
    {
        $request->validate([
            "brand_id" => "required",
        ]);

        $data = BrandModel::where('brand_id', $request->brand_id)->latest('id')->get();

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => $data,
        ];
    }

    public function getModelYears(Request $request)
    {
        $request->validate([
            "model_id" => "required",
        ]);

        $data = ModelYear::where('model_id', $request->model_id)->latest('id')->get();

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => $data,
        ];
    }
    public function getRegionalSpecs(Request $request)
    {
        $data = RegionalSpec::latest('id')->get();

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => $data,
        ];
    }
    public function getBodyTypes(Request $request)
    {
        $data = BodyType::latest('id')->get();

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => $data,
        ];
    }

    public function getSupportDetails(Request $request)
    {
        $setting = Setting::where('name', 'support_details')->pluck('value')->first();
        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => json_decode($setting, true),
        ];
    }
    public function getPages(Request $request)
    {
        $setting = Setting::whereIn('name', ['privacy_policy', 'terms_conditions'])->get()->pluck('value', 'name')->toArray();
        return [
            'status'  => true,
            'message' => "pages get successfully!",
            'data'    => $setting,
        ];
    }

    public function updateProfile(Request $request)
    {
        $authUser = auth()->user();
        $usertype = $authUser->usertype;
        $id       = $authUser->id;

        // Validate email and phone uniqueness
        $request->validate([
            'email' => [
                'sometimes',
                'email',
                Rule::unique('allusers')->ignore($id)->where(fn($query) => $query->where('usertype', $usertype)),
            ],
            'phone' => [
                'sometimes',
                Rule::unique('allusers')->ignore($id)->where(fn($query) => $query->where('usertype', $usertype)),
            ],
        ]);

        $data        = [];
        $companyData = [];

        // Fill user profile data
        foreach (['fname', 'lname', 'city', 'lat', 'lng', 'location'] as $field) {
            if ($request->filled($field)) {
                $data[$field] = $request->$field;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image   = $request->file('image');
            $imgname = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('users'), $imgname);

            $data['image']              = 'users/' . $imgname;
            $companyData['company_img'] = 'users/' . $imgname;
        }

        // Load user with relationship
        $user = allUsersModel::with('workshop_provider')->find($id);
        $user->update($data);

        if ($usertype !== 'workshop_provider') {
            // For car dealers
            $companyData['company_name']    = $request->company_name;
            $companyData['company_address'] = $user->location;

            $carDealer = CarDealer::firstOrCreate(['user_id' => $user->id]);
            $carDealer->update($companyData);

            return [
                'status'       => true,
                'message'      => "Profile updated successfully!",
                'user'         => new UserResource($user),
                'company_data' => new ShopResource($carDealer),
            ];
        } else {
            // For workshop providers
            $workshop = $user->workshop_provider;

            if (! $workshop) {
                // Create if not exists
                $workshop = WorkshopProvider::create([
                    'user_id'   => $user->id,
                    'branch'    => $user->city,
                    'latitude'  => $user->lat,
                    'longitude' => $user->lng,
                    'address'   => $user->location,
                ]);
            } else {
                $workshop->update([
                    'branch'    => $user->city,
                    'latitude'  => $user->lat,
                    'longitude' => $user->lng,
                    'address'   => $user->location,
                ]);
            }

            return [
                'status'        => true,
                'message'       => "Profile updated successfully!",
                'user'          => new UserResource($user),
                'workshop_data' => new WorkshopResource($workshop),
            ];
        }
    }
}
