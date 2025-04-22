<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResource;
use App\Http\Resources\SparepartCategoryResource;
use App\Http\Resources\UserResource;
use App\Models\allUsersModel;
use App\Models\CarDealer;
use App\Models\SparePart;
use App\Models\Package;
use App\Models\UserPackageSubscription;
use App\Models\SparepartCategory;
use App\Models\SparePartImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
        "email"        => 'required|email|unique:allusers,email,NULL,id,userType,shop_dealer',
        'fname'        => 'required',
        'company_name' => 'required',
        'password'     => 'required|min:6',
    ]);

        $user = allUsersModel::create([
            'fname'    => $request['fname'],
            'lname'    => $request['lname'],
            'phone'    => $request['phone'],
            'email'    => $request['email'],
            'city'     => $request['city'] ?? '',
            'lat'      => $request['lat'] ?? '',
            'lng'      => $request['lng'] ?? '',
            'password' => bcrypt($request['password']),
            "userType" => "shop_dealer",
        ]);
        $cData = [
            "company_name"    => $request->company_name,
            "company_address" => $request->company_address,
            "user_id"         => $user->id,
        ];

        if ($request->hasFile('company_img')) {
            $img1     = $request->file('company_img');
            $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
            $path     = Storage::disk('r2')->put('dealers/' . $imgname1, file_get_contents($img1));
            // $img1->move(public_path('dealers'), $imgname1);
            $company_img          = 'dealers/' . $imgname1;
            $cData['company_img'] = $company_img;

        } else {
            $company_img          = 'icon/notfound.png';
            $cData['company_img'] = $company_img;
        }
        $user->update(['image' => $cData['company_img']]);

        $user->dealer = CarDealer::create($cData);

        // subscripe to package
        if ($request->package_id) {
            $package = Package::findOrFail($request->package_id);

            $start = now();
            if ($package->period_type == 'Years') {
                $period = $package->period * 12;
                $end    = $start->copy()->addMonths($period);
            } else {
                $end = $start->copy()->addMonths($package->period);
            }

            $subscription = UserPackageSubscription::create([
                'user_id'    => $user->id,
                'package_id' => $package->id,
                'price'      => $package->price,
                'starts_at'  => $start,
                'ends_at'    => $end,
                'status'     => 'active',
                'renewed'    => false,
            ]);
        }else{
            $package = Package::where('title', 'free Spare Part Provider')->first();
            $start = now();
            if ($package->period_type == 'Years') {
                $period = $package->period * 12;
                $end    = $start->copy()->addMonths($period);
            } else {
                $end = $start->copy()->addMonths($package->period);
            }

            $subscription = UserPackageSubscription::create([
                'user_id'    => $user->id,
                'package_id' => $package->id,
                'price'      => $package->price,
                'starts_at'  => $start,
                'ends_at'    => $end,
                'status'     => 'active',
                'renewed'    => false,
            ]);
        }

        if ($user) {
            return [
                'status'  => true,
                'message' => 'Accounted created Successfully!',
                'data'    => [
                    "auth_token" => $user->createToken('tokens')->plainTextToken,
                    "user"       => new UserResource($user),
                ],
            ];
        } else {
            return [
                'status'  => false,
                'message' => 'Password is wronged!',
                'data'    => null,
            ];

        }}
    public function login(Request $request)
    {
        //    dd(bcrypt('123456'));
        if (isset($request->firebase_auth) && $request->firebase_auth == true) {
            return $this->phoneLogin($request);
        }
        $request->validate([
            "email"    => 'required|email',
            'password' => 'required',
        ]);

        $user = allUsersModel::where(['email' => $request['email'], "userType" => "shop_dealer"])
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
            return [
                'status'  => false,
                'message' => 'Password is wronged!',
                'data'    => null,
            ];

        }

    }

    public function phoneLogin(Request $request)
    {

        $request->validate([
            "phone" => 'required',
        ]);

        $user = allUsersModel::where(['phone' => $request['phone'], "userType" => "shop_dealer"])
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
        $user = allUsersModel::with('dealer')->where([
            "id" => auth()->user()->id,
        ])->first();

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                'user'         => new UserResource($user),
                'company_data' => new ShopResource($user->dealer),
            ],
        ];
    }

    public function getSparepartCategories(Request $request)
    {
        $categories = SparepartCategory::whereNull('parent_id')->get();
        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => SparepartCategoryResource::collection($categories),
        ];
    }
    public function getSubCategories(Request $request)
    {
        $request->validate([
            "category_id" => "required",
        ]);
        $categories = SparepartCategory::where('parent_id', $request->category_id)->get();

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => SparepartCategoryResource::collection($categories),
        ];
    }

    //*****************Updated Function Decoding Array Of Years************************
    public function myProducts(Request $request)
    {
        $spare_parts = SparePart::with('images', 'category')
            ->where('user_id', auth()->user()->id)
            ->latest('id');

        if (isset($request->brand) && $request->brand != 'All') {
            $spare_parts->where('brand', $request->brand);
        }
        if (isset($request->priceFrom) && $request->priceFrom != 0) {
            $spare_parts->where('price', '>=', $request->priceFrom);
        }
        if (isset($request->priceTo) && $request->priceTo != 0) {
            $spare_parts->where('price', '<=', $request->priceTo);
        }
        if (isset($request->category) && $request->category != 'All') {
            $spare_parts->where('category_id', $request->category);
        }

        $spare_parts = $spare_parts->paginate(15);

        $appUrl = env('APP_URL');
        $r2     = env('CLOUDFLARE_R2_URL');

        $spare_parts->getCollection()->transform(function ($spare_part) use ($appUrl, $r2) {
            // Decode year
            $spare_part->year = json_decode($spare_part->year, true);

            // Decode car_model
            if (is_string($spare_part->car_model)) {
                $decodedCarModel       = json_decode($spare_part->car_model, true);
                $spare_part->car_model = (is_array($decodedCarModel) || strpos($spare_part->car_model, '[') === false)
                ? $decodedCarModel
                : $spare_part->car_model;
            }

            // Decode deleteKey
            if (is_string($spare_part->deleteKey)) {
                $decodedDeleteKey      = json_decode($spare_part->deleteKey, true);
                $spare_part->deleteKey = is_array($decodedDeleteKey)
                ? $decodedDeleteKey
                : $spare_part->deleteKey;
            }

            // Modify image URLs
            if ($spare_part->relationLoaded('images')) {
                $spare_part->images->transform(function ($image) use ($appUrl, $r2) {
                    if ($image->image) {
                        $image->image = str_replace($appUrl, $r2, $image->image);
                    }
                    return $image;
                });
            }

            // Modify category image URL
            if ($spare_part->relationLoaded('category') && $spare_part->category?->image) {
                $spare_part->category->image = str_replace($appUrl, $r2, $spare_part->category->image);
            }

            return $spare_part;
        });

        return [
            'status'  => true,
            'message' => "Data get successfully!!",
            'data'    => [
                "spare_parts" => $spare_parts->items(),
                "pagination"  => [
                    'current_page' => $spare_parts->currentPage(),
                    'per_page'     => $spare_parts->perPage(),
                    'total'        => $spare_parts->total(),
                    'last_page'    => $spare_parts->lastPage(),
                ],
            ],
        ];
    }

    //  *****************Updated Function Getting Array Of Years************************

    public function addProduct(Request $request)
    {
        $validatedData = $request->validate([
            "title"        => "required",
            "brand"        => "required",
            'car_model'    => "required|array", // Ensure car_model is an array
            "model"        => "nullable",
            "year"         => "required|array", // Validate as an array
            "part_type"    => "required",
            "category_ids" => "required",
        ]);

        // Convert 'car_model' and 'year' arrays to JSON format before storing
        $validatedData['car_model'] = json_encode($request->car_model);
        $validatedData['year']      = json_encode($request->year);
        $validatedData['deleteKey'] = json_encode([]);
        // $validatedData['desc'] = $request->desc;

        $validatedData['desc'] = $request->input('desc', '');
        $validatedData += [
            'user_id'    => auth()->user()->id,
            'vin_number' => $request->vin_number ?? '', 'city' => $request->city ?? '',
        ];

        // Handle categories
        $category_ids = explode(',', $request->category_ids);
        $categories   = SparepartCategory::whereIn('id', $category_ids)->get();

        if (isset($request->all_categories) && $request->all_categories == true) {
            $categories = SparepartCategory::all();
        }

        // Ensure the category-related images don't interfere
        unset($validatedData['images']);
        unset($validatedData['category_ids']);

        // Initialize $data as an empty array or null
        $data = null;

        // Process each category
        foreach ($categories as $cat) {
            $validatedData['title']       = $cat->name;
            $validatedData['category_id'] = $cat->id;

            // Create the SparePart record
            $data = SparePart::create($validatedData);

            // Handle images
            if ($request->images) {
                foreach ($request->images as $image) {
                    if ($image) {
                        $img1     = $image;
                        $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
                        $path     = Storage::disk('r2')->put('spareparts/' . $imgname1, file_get_contents($img1));
                        // $img1->move(public_path('spareparts'), $imgname1);
                        $final_img = 'spareparts/' . $imgname1;
                        SparePartImage::create([
                            "spare_part_id" => $data->id,
                            "image"         => $final_img,
                        ]);
                    }
                }
            } else {
                // Default image if none is provided
                SparePartImage::create([
                    "spare_part_id" => $data->id,
                    "image"         => 'icon/sparepart.jpg',
                ]);
            }
        }

        // Decode 'car_model' and 'year' before returning the response
        if ($data) {
            $data->car_model = json_decode($data->car_model);
            $data->year      = json_decode($data->year);
            $data->deleteKey = json_decode($data->deleteKey);
            return [
                'status'  => true,
                'message' => "Spare Part listed successfully!",
                'data'    => $data,
            ];
        } else {
            // If no categories were found or no data was created
            return [
                'status'  => false,
                'message' => "Failed to list the Spare Part. No categories were found or processed.",
            ];
        }
    }

// Updated Function for years
    public function delProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:spare_parts,id', // Validate that the product_id exists in the spare_parts table
        ]);
        try {

            $product = SparePart::findOrFail($request->product_id);

            // Decode the car_model field if it's a JSON string
            if (is_string($product->car_model)) {
                $carModels = json_decode($product->car_model, true);
            } else {
                $carModels = $product->car_model;
            }

            // Ensure car_model is an array
            if (! is_array($carModels)) {
                $carModels = [];
            }

            // Check if isDelete is true (as string "true")
            if ($request->isDelete === "true") {
                // Delete the product
                $product->delete();
                return [
                    'status'  => true,
                    'message' => "Product deleted successfully!",
                    'data'    => $this->formatProductData($product),
                ];
            } else {
                // isDelete is false, proceed with concatenating model_name and year
                $modelName = $request->model_name;
                $year      = $request->year;

                if (! empty($modelName) && ! empty($year)) {
                    // Concatenate model_name and year
                    $concatenatedValue = $modelName . '' . $year;

                    // Handle the deleteKey field
                    $deleteKey = $product->deleteKey;

                    // If deleteKey is a JSON string, decode it, or initialize as an empty array
                    if (is_string($deleteKey)) {
                        $deleteKeyArray = json_decode($deleteKey, true);
                    } else {
                        $deleteKeyArray = $deleteKey;
                    }

                    if (! is_array($deleteKeyArray)) {
                        $deleteKeyArray = [];
                    }

                    // Push the concatenated value into the array
                    $deleteKeyArray[] = $concatenatedValue;

                    // Save the updated deleteKey back as a JSON string
                    $product->deleteKey = json_encode($deleteKeyArray);
                    $product->save();

                    return [
                        'status'  => true,
                        'message' => "Product updated with deleteKey!",
                        'data'    => $this->formatProductData($product),
                    ];
                } else {
                    return [
                        'status'  => false,
                        'message' => "Model name or year is missing.",
                        'data'    => null,
                    ];
                }
            }
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return [
                'status'  => false,
                'message' => "An error occurred: " . $e->getMessage(),
                'data'    => null,
            ];
        }
    }

// Helper function to format product data
    private function formatProductData($product)
    {
        // Decode year if it's a valid JSON string
        if (is_string($product->year)) {
            $decodedYear   = json_decode($product->year, true);
            $product->year = (is_array($decodedYear) || strpos($product->year, '[') === false) ? $decodedYear : $product->year;
        }

        // Decode car_model if it's a valid JSON string
        if (is_string($product->car_model)) {
            $decodedCarModel    = json_decode($product->car_model, true);
            $product->car_model = is_array($decodedCarModel) ? $decodedCarModel : $product->car_model;
        }
        if (is_string($product->deleteKey)) {
            $decodedDeleteKey   = json_decode($product->deleteKey, true);
            $product->deleteKey = is_array($decodedDeleteKey) ? $decodedDeleteKey : $product->deleteKey;
        }
        return $product;
    }

    public function updateProfile(Request $request)
    {

        $data = [];
        if ($request->name) {
            $data['name'] = $request->name;
        }
        if ($request->email) {
            $data['email'] = $request->email;
        }
        $image = $request->file('picture');
        if ($image) {
            $imageName = date('YmdHis') . "_user." . $image->getClientOriginalExtension();
            $path      = Storage::disk('r2')->put('uploads/' . $imageName, file_get_contents($image));
            // $image->move(public_path('uploads/'), $imageName);
            $data['picture'] = $imageName;
        }
        if ($request->address) {
            $data['location'] = $request->address;
        }
        if ($request->lat) {
            $data['lat'] = $request->lat;
        }
        if ($request->lng) {
            $data['lng'] = $request->lng;
        }

        // else{  $imageName ="null";}

        $user = allUsersModel::whereId($request->user()->id)->update($data);
        if ($user) {
            return [
                'status'  => true,
                'message' => "Profile updated successfully!",
                'data'    => [],
            ];
        }
    }

    public function getAllSpareParts()
    {
        $spareParts = SparePart::all();

        return response()->json($spareParts);
    }

}
