<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCarResource;
use App\Models\admin\adminAuthModel;
use App\Models\allUsersModel;
use App\Models\BrandModel;
use App\Models\CarBrand;
use App\Models\carListingModel;
use App\Models\ModelYear;
use App\Models\Setting;
use App\Models\SparePart;
use App\Models\SparepartCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{

    public function test(Request $request)
    {
        if (isset($_FILES['csv']) && $_FILES['csv']['error'] === UPLOAD_ERR_OK) {

            $csvFile = $_FILES['csv']['tmp_name'];
            $data    = array_map('str_getcsv', file($csvFile));
            foreach ($data as $key => $row) {
                $model = BrandModel::where(["name" => $row[1]])->first();
                ModelYear::create([
                    "model_id" => $model->id,
                    "name"     => $row[2],
                ]);
                if (isset($row[3])) {
                    ModelYear::create([
                        "model_id" => $model->id,
                        "name"     => $row[3],
                    ]);
                }
                if (isset($row[4])) {
                    ModelYear::create([
                        "model_id" => $model->id,
                        "name"     => $row[4],
                    ]);
                }
            }
        }
        return [
            'status'  => true,
            'message' => 'Success',
            'data'    => null,
        ];
    }

    public function registerAdmin(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'required|email|unique:admin_settings,email',
                'name'     => ['required', Rule::unique('admin_settings')->where('name', $request->name)],
                'password' => 'required|min:6',
            ]);

            try {
                $admin            = new AdminAuthModel();
                $admin->name      = $request->name;
                $admin->email     = $request->email;
                $admin->api_token = '';
                $admin->pass      = Hash::make($request->password);
                $admin->save();

                return response()->json([
                    'status'  => true,
                    'message' => 'Admin registered successfully.',
                    'data'    => $admin,
                ], 201);

            } catch (ValidationException $e) {
                // Validation failed
                return response()->json([
                    'status'  => false,
                    'message' => 'Sorry try different username or email',
                    'errors'  => $e->errors(),
                    'data'    => null,
                ], 422);
            } catch (\Exception $e) {
                // General exception
                return response()->json([
                    'status'  => false,
                    'message' => 'An error occurred during registration.',
                    'error'   => $e->getMessage(),
                    'data'    => null,
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Sorry try different username or email',
                'errors'  => $e->errors(),
                'data'    => null,
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred during registration.',
                'error'   => $e->getMessage(),
                'data'    => null,
            ], 500);
        }
    }
    public function getAllAdmins()
    {
        $allAdmins = AdminAuthModel::orderBy('id', 'desc')->get();
        if ($allAdmins->count() > 0) {
            return response()->json([
                "status" => true,
                "data"   => $allAdmins,
            ], 200);
        } else {
            return response()->json([
                "status"  => false,
                "Message" => "Users Records is Empty",
            ], 404);
        }
    }
    public function delAdmin(Request $request)
    {
        $id    = $request->id;
        $admin = AdminAuthModel::find($id);
        if ($admin) {
            $admin->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Admin deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Admin not found',
            ], 404);
        }
    }

    public function login(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            // Find the user by email
            $user = AdminAuthModel::where('email', $request->email)->first();

            if (! $user) {
                // User not found
                return response()->json([
                    'status'  => false,
                    'message' => 'Email is incorrect or not registered!',
                    'data'    => null,
                ], 404);
            }

            // Check the password
            if (! Hash::check($request->password, $user->pass)) {
                // Invalid password
                return response()->json([
                    'status'  => false,
                    'message' => 'Password is incorrect!',
                    'data'    => null,
                ], 401);
            }

            // Generate the token
            $token = $user->createToken('tokens')->plainTextToken;

            // Update the user's api_token (if needed)
            $user->update(['api_token' => $token]);

            // Successful login
            return response()->json([
                'status'  => true,
                'message' => 'Login successful!',
                'data'    => [
                    'auth_token' => $token,
                    'user'       => $user,
                ],
            ], 200);
        } catch (ValidationException $e) {
            // Validation failed
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $e->errors(),
                'data'    => null,
            ], 422);
        } catch (\Exception $e) {
            // General exception
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred during login.',
                'error'   => $e->getMessage(),
                'data'    => null,
            ], 500);
        }
    }
    public function logout()
    {

        auth()->user()->tokens()->delete();

        return [
            "status"  => true,
            'message' => 'You Logout successfully',
            "data"    => [],
        ];
    }

    public function userAccStatus(Request $request)
    {
        // dd(auth()->user());

        allUsersModel::findOrFail($request->user_id)->update([
            "acc_status" => $request->acc_status,
        ]);

        return [
            "status"  => true,
            'message' => 'Account Status updated successfully',
            "data"    => [],
        ];
    }

    public function getDashboard(Request $request)
    {
        $data = [];

        $data['new_cars']     = carListingModel::where('car_type', 'New')->count();
        $data['used_cars']    = carListingModel::where('car_type', 'Used')->count();
        $data['auction_cars'] = carListingModel::where('car_type', 'Auction')->count();
        $data['total_cars']   = $data['new_cars'] + $data['used_cars'] + $data['auction_cars'];

        $data['total_users']       = allUsersModel::where('usertype', 'user')->count();
        $data['car_dealers']       = allUsersModel::where('usertype', 'dealer')->count();
        $data['sparepart_dealers'] = allUsersModel::where('usertype', 'shop_dealer')->count();
        $data['workshop_dealers']  = allUsersModel::where('usertype', 'workshop')->count();

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => $data,
        ];
    }

    public function getCarsListing(Request $request)
    {
        $carListings = carListingModel::query();
        $carListings->orderBy('id', 'desc');

        if (isset($request->search) && $request->search != '') {
            $carListings->where(function ($query) use ($request) {
                $query->where('listing_title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('listing_desc', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('listing_type', 'LIKE', '%' . $request->search . '%');
            });
        }
        if (isset($request->brand) && $request->brand != '') {
            $carListings->where('listing_type', $request->brand);
        }
        if (isset($request->model) && $request->model != '') {
            $carListings->where('listing_model', $request->model);
        }
        if (isset($request->year) && $request->year != '') {
            $carListings->where('listing_year', $request->year);
        }

        if (isset($request->car_type) && $request->car_type != 'All') {
            $carListings->where('car_type', $request->car_type);
        }
        if (isset($request->body_type) && $request->body_type != '') {
            $carListings->where('body_type', $request->body_type);
        }
        if (isset($request->regional_specs) && $request->regional_specs != '') {
            $carListings->where('regional_specs', $request->regional_specs);
        }
        if (isset($request->city) && $request->city != '') {
            $carListings->where('city', $request->city);
        }

        if (isset($request->priceFrom) && $request->priceFrom != 0) {
            $carListings->where('listing_price', '>=', $request->priceFrom);
        }
        if (isset($request->priceTo) && $request->priceTo != 0) {
            $carListings->where('listing_price', '<=', $request->priceTo);
        }
        if (isset($request->speedFrom) && $request->speedFrom != 0) {
            $carListings->where('features_speed', '>=', $request->speedFrom);
        }
        if (isset($request->speedTo) && $request->speedTo != 0) {
            $carListings->where('features_speed', '<=', $request->speedTo);
        }

        if (isset($request->dateFrom) && $request->dateFrom != '') {
            $carListings->whereDate('created_at', '>=', $request->dateFrom);
        }
        if (isset($request->dateTo) && $request->dateTo != '') {
            $carListings->whereDate('created_at', '<=', $request->dateTo);
        }
        $sort = ($request->sort == "asc") ? "asc" : "desc";
        if (isset($request->sort_by) && $request->sort_by == 'date') {
            $carListings->orderBy('created_at', $sort);
        } elseif (isset($request->sort_by) && $request->sort_by == 'price') {
            $carListings->orderBy('listing_price', $sort);
        } elseif (isset($request->sort_by) && $request->sort_by == 'speed') {
            $carListings->orderBy('features_speed', $sort);
        } else {
            $carListings->latest('id');
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

    public function getSpareParts(Request $request)
    {
        $carListings = SparePart::with(['images', 'user'])->latest('id');

        if (isset($request->search) && $request->search != '') {
            $carListings->where('title', 'LIKE', '%' . $request->search . '%')->orWhere('brand', 'LIKE', '%' . $request->search . '%')
                ->orWhere('model', 'LIKE', '%' . $request->search . '%');
        }
        if (isset($request->priceFrom) && $request->priceFrom != 0) {
            $carListings->where('price', '>=', $request->priceFrom);
        }
        if (isset($request->priceTo) && $request->priceTo != 0) {
            $carListings->where('price', '<=', $request->priceTo);
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

    public function getAllBrands(Request $request)
    {

        $data = CarBrand::latest('id');
        if (isset($request->search)) {
            $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "items"      => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }

    public function getAllModels(Request $request)
    {

        $data = BrandModel::with('brand')->has('brand')->latest('id');
        if (isset($request->search)) {
            $data->where('name', 'LIKE', '%' . $request->search . '%')->orWhereHas('brand', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%');
            });
        }
        $data = $data->paginate(15);
        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "items"      => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }

    public function getAllYears(Request $request)
    {

        $data = ModelYear::with('model.brand')->has('model')->latest('id')->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "items"      => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }

    public function addCategory(Request $request)
    {
        if (isset($request->category_id) && $request->category_id != '') {
            $validatedData = $request->validate([
                'name' => [
                    'required',
                    Rule::unique('sparepart_categories')->ignore($request->category_id),
                ],
            ]);
            if ($request->hasFile('image')) {
                $img5     = $request->file('image');
                $imgname5 = time() . '.' . $img5->getClientOriginalExtension();
                $img5->move(public_path('spareparts'), $imgname5);
                $listing_img5           = 'spareparts/' . $imgname5;
                $validatedData['image'] = $listing_img5;
            }

            $brand = SparepartCategory::find($request->category_id)->update($validatedData);
            return [
                'status'  => true,
                'message' => "SparepartCategory updated successfully!",
                'data'    => $brand,
            ];
        } else {
            $validatedData = $request->validate([
                "name" => "required|unique:sparepart_categories",
            ]);
            if ($request->hasFile('image')) {
                $img5     = $request->file('image');
                $imgname5 = time() . '.' . $img5->getClientOriginalExtension();
                $img5->move(public_path('spareparts'), $imgname5);
                $listing_img5           = 'spareparts/' . $imgname5;
                $validatedData['image'] = $listing_img5;
            }
            $brand = SparepartCategory::create($validatedData);
            return [
                'status'  => true,
                'message' => "SparepartCategory created successfully!",
                'data'    => $brand,
            ];
        }
    }
    public function delCategory(Request $request)
    {
        $validatedData = $request->validate([
            "category_id" => "required",
        ]);
        $brand = SparepartCategory::findOrFail($request->category_id)->delete();
        return [
            'status'  => true,
            'message' => "SparepartCategory deleted successfully!",
            'data'    => $brand,
        ];
    }

    public function getSparepartCategories(Request $request)
    {
        $data = SparepartCategory::whereNull('parent_id')->latest('id');
        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "items"      => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }

    public function getBrandModels(Request $request)
    {

        $data = BrandModel::with('brand')->whereHas('brand')->latest('id')->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "items"      => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }

    public function getModelYears(Request $request)
    {

        $data = ModelYear::with('model.brand')->whereHas('model')->latest('id')->get();

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => $data,
        ];
    }

    public function addBrand(Request $request)
    {
        if (isset($request->id) && $request->id != '') {
            $validatedData = $request->validate([
                'name' => [
                    'required',
                    Rule::unique('car_brands')->ignore($request->id),
                ],
            ]);
            $brand = CarBrand::find($request->id)->update([
                "name" => $request->name,
            ]);
            return [
                'status'  => true,
                'message' => "Brand updated successfully!",
                'data'    => $brand,
            ];
        } else {
            $validatedData = $request->validate([
                "name" => "required|unique:car_brands",
            ]);
            $brand = CarBrand::create($validatedData);
            return [
                'status'  => true,
                'message' => "Brand created successfully!",
                'data'    => $brand,
            ];
        }
    }
    public function delBrand(Request $request)
    {
        $validatedData = $request->validate([
            "brand_id" => "required",
        ]);
        $brand = CarBrand::findOrFail($request->brand_id)->delete();
        return [
            'status'  => true,
            'message' => "Car Brand deleted successfully!",
            'data'    => $brand,
        ];
    }
    public function delModel(Request $request)
    {
        $validatedData = $request->validate([
            "model_id" => "required",
        ]);
        $model = BrandModel::findOrFail($request->model_id)->delete();
        return [
            'status'  => true,
            'message' => "Brand Model deleted successfully!",
            'data'    => $model,
        ];
    }
    public function delYear(Request $request)
    {
        $validatedData = $request->validate([
            "year_id" => "required",
        ]);
        $model = ModelYear::findOrFail($request->year_id)->delete();
        return [
            'status'  => true,
            'message' => " Model year is deleted successfully!",
            'data'    => $model,
        ];
    }

    public function addBrandModel(Request $request)
    {
        if (isset($request->model_id) && $request->model_id != '') {
            $validatedData = $request->validate([
                'name'     => [
                    'required',
                    Rule::unique('brand_models')->ignore($request->model_id),
                ],
                "brand_id" => "required",

            ]);
            $brand = BrandModel::find($request->model_id)->update([
                "name"     => $request->name,
                "brand_id" => $request->brand_id,
            ]);
            return [
                'status'  => true,
                'message' => "Brand Model updated successfully!",
                'data'    => $brand,
            ];
        } else {
            $validatedData = $request->validate([
                "name"     => "required|unique:brand_models",
                "brand_id" => "required",
            ]);
            $brand = BrandModel::create($validatedData);
            return [
                'status'  => true,
                'message' => "BrandModel created successfully!",
                'data'    => $brand,
            ];
        }
    }

    public function addModelYear(Request $request)
    {
        if (isset($request->year_id) && $request->year_id != '') {
            $validatedData = $request->validate([
                'name'     => [
                    'required',
                ],
                "model_id" => "required",
            ]);
            $brand = ModelYear::find($request->year_id)->update([
                "name"     => $request->name,
                "model_id" => $request->model_id,
            ]);
            return [
                'status'  => true,
                'message' => " Model Year updated successfully!",
                'data'    => $brand,
            ];
        } else {
            $validatedData = $request->validate([
                "name"     => "required",
                "model_id" => "required",
            ]);
            $brand = ModelYear::create($validatedData);
            return [
                'status'  => true,
                'message' => "BrandModel Year created successfully!",
                'data'    => $brand,
            ];
        }
    }

    public function getUsers(Request $request)
    {
        $users = allUsersModel::with('dealer')->withCount('cars')->where('usertype', $request->user_type)->latest('id');
        $users = $users->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "users"      => $users->items(),
                "pagination" => [
                    'current_page' => $users->currentPage(),
                    'per_page'     => $users->perPage(),
                    'total'        => $users->total(),
                    'last_page'    => $users->lastPage(),
                ],
            ],
        ];
    }

    public function getUserDetails(Request $request)
    {
        // dd($request);
        $user = allUsersModel::with('dealer')->findOrFail($request->id);

        $user->cars = carListingModel::where(["user_id" => $user->id])->get();
        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => $user,
        ];
    }

    public function delCar(Request $request)
    {
        $validatedData = $request->validate([
            "car_id" => "required",
        ]);
        $brand = carListingModel::findOrFail($request->car_id)->delete();
        return [
            'status'  => true,
            'message' => "Car is deleted successfully!",
            'data'    => $brand,
        ];
    }

    public function delSparePart(Request $request)
    {
        $validatedData = $request->validate([
            "id" => "required",
        ]);
        $data = SparePart::findOrFail($request->id)->delete();
        return [
            'status'  => true,
            'message' => "Spare Part is deleted successfully!",
            'data'    => $data,
        ];
    }

    public function getSettings(Request $request)
    {
        if ($request->search == "support") {
            $data = Setting::where('name', 'support_details')->first();
            $data = json_decode($data->value, true);
        } elseif ($request->search == "pages") {
            $data = Setting::whereIn('name', ['privacy_policy', 'terms_conditions'])->get()->pluck('value', 'name')->toArray();
        }

        return [
            'status'  => true,
            'message' => "settings get successfully!",
            'data'    => $data,
        ];
    }

    public function updateSettings(Request $request)
    {
        if ($request->search == "support") {
            $settings = json_encode($request->data);
            Setting::where('name', 'support_details')->update([
                "value" => $settings,
            ]);
        } elseif ($request->search == "pages") {
            Setting::where('name', 'privacy_policy')->update([
                "value" => $request->data['privacy_policy'],
            ]);
            Setting::where('name', 'terms_conditions')->update([
                "value" => $request->data['terms_conditions'],
            ]);
        }

        return [
            'status'  => true,
            'message' => "settings updated successfully!",
            'data'    => [],
        ];
    }

    public function getProfile(Request $request)
    {

        $user = adminAuthModel::find($request->user()->id);

        if ($user) {
            return [
                'status'  => true,
                'message' => "Profile get successfully!",
                'data'    => $user,
            ];
        }
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
            $image->move(public_path('uploads/'), $imageName);
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

        $user = adminAuthModel::whereId($request->user()->id)->update($data);
        if ($user) {
            return [
                'status'  => true,
                'message' => "Profile updated successfully!",
                'data'    => [],
            ];
        }
    }
}
