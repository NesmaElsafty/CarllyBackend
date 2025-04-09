<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResource;
use App\Http\Resources\UserResource;
use App\Models\admin\adminAuthModel;
use App\Models\allUsersModel;
use App\Models\CarDealer;
use App\Models\SparePart;
use App\Models\SparepartCategory;
use App\Models\SparePartImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShopController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "email"        => 'required|email|unique:allusers,email,NULL,id,userType,shop_dealer',
            "phone"        => 'required|unique:allusers,phone,NULL,id,usertype,shop_dealer',
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
            'location' => $request['company_address'] ?? '',
            'password' => bcrypt($request['password']),
            "usertype" => "shop_dealer",
        ]);
        $cData = [
            "company_name"    => $request->company_name,
            "company_address" => $request->company_address,
            "user_id"         => $user->id,
        ];


        if($request->hasFile('company_img')) {
            $img1 = $request->file('company_img');
           $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
           
           $path = Storage::disk('r2')->put('dealers/' . $imgname1, file_get_contents($img1));   

           $company_img = 'dealers/'.$imgname1;
           $cData['company_img']=$company_img;

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
        $user = auth()->user();
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
            'data'    => $categories,
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
            'data'    => $categories,
        ];
    }

    public function myProducts(Request $request)
    {
        $spare_parts = SparePart::with('images', 'category')->where('user_id', auth()->user()->id)->latest('id');

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
            $spare_parts->where('price', '<=', $request->priceTo);
        }

        $spare_parts = $spare_parts->paginate(15);
        $spare_parts->getCollection()->transform(function ($spare_part) {
            $spare_part->year = json_decode($spare_part->year, true);
            if (is_string($spare_part->car_model)) {
                $decodedCarModel = json_decode($spare_part->car_model, true);
                // If decoding results in null and the original string is not an array format, keep the original
                $spare_part->car_model = (is_array($decodedCarModel) || strpos($spare_part->car_model, '[') === false) ? $decodedCarModel : $spare_part->car_model;
            }
            if (is_string($spare_part->deleteKey)) {
                $decodedDeleteKey      = json_decode($spare_part->deleteKey, true);
                $spare_part->deleteKey = is_array($decodedDeleteKey) ? $decodedDeleteKey : $spare_part->deleteKey;
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
            'car_model'    => "required|array",
            "model"        => "nullable",
            "year"         => "required|array",
            "part_type"    => "required",
            "category_ids" => "required",
        ]);

        // تحويل البيانات إلى JSON
        $validatedData['car_model'] = json_encode($request->car_model);
        $validatedData['year']      = json_encode($request->year);
        $validatedData['deleteKey'] = json_encode([]);

        // باقي البيانات
        $validatedData['desc'] = $request->input('desc', '');
        $validatedData += [
            'user_id'    => auth()->user()->id,
            'vin_number' => $request->vin_number ?? '',
            'city'       => $request->city ?? '',
        ];

        // فك التصنيفات
        $category_ids = explode(',', $request->category_ids);
        if (isset($request->all_categories) && $request->all_categories == true) {
            $category_ids = SparepartCategory::pluck('id')->toArray();
        }

        // إنشاء المنتج مرة واحدة
        $product = SparePart::create($validatedData);

        // ربط التصنيفات بالمنتج
        $product->categories()->attach($category_ids);

        // رفع الصور
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                if ($image) {
                    $imgname = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('spareparts'), $imgname);
                    $final_img = 'spareparts/' . $imgname;

                    SparePartImage::create([
                        "spare_part_id" => $product->id,
                        "image"         => $final_img,
                    ]);
                }
            }
        } else {
            SparePartImage::create([
                "spare_part_id" => $product->id,
                "image"         => 'icon/sparepart.jpg',
            ]);
        }

        // فك بيانات JSON قبل الرجوع بالرد
        $product->car_model = json_decode($product->car_model);
        $product->year      = json_decode($product->year);
        $product->deleteKey = json_decode($product->deleteKey);
        $product->load('categories');

        return [
            'status'  => true,
            'message' => "Spare Part listed successfully!",
            'data'    => $product,
        ];
    }

    public function updateProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            "title"        => "required",
            "brand"        => "required",
            'car_model'    => "required|array",
            "model"        => "nullable",
            "year"         => "required|array",
            "part_type"    => "required",
            "category_ids" => "required",
        ]);

        // تحميل المنتج
        $product = SparePart::findOrFail($id);

        // تحويل بعض البيانات إلى JSON
        $validatedData['car_model'] = json_encode($request->car_model);
        $validatedData['year']      = json_encode($request->year);
        $validatedData['deleteKey'] = json_encode($request->deleteKey ?? []);

        // باقي البيانات
        $validatedData['desc'] = $request->input('desc', '');
        $validatedData += [
            'vin_number' => $request->vin_number ?? '',
            'city'       => $request->city ?? '',
            'model'      => $request->model ?? '',
        ];

        // تحديث المنتج
        $product->update($validatedData);

        // تحديث التصنيفات
        $category_ids = explode(',', $request->category_ids);
        if (isset($request->all_categories) && $request->all_categories == true) {
            $category_ids = SparepartCategory::pluck('id')->toArray();
        }
        $product->categories()->sync($category_ids);

        // حذف الصور القديمة لو فيه صور جديدة
        if ($request->hasFile('images')) {
            // حذف الصور القديمة
            SparePartImage::where('spare_part_id', $product->id)->delete();

            // رفع الصور الجديدة
            foreach ($request->images as $image) {
                if ($image) {
                    $imgname = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('spareparts'), $imgname);
                    $final_img = 'spareparts/' . $imgname;

                    SparePartImage::create([
                        "spare_part_id" => $product->id,
                        "image"         => $final_img,
                    ]);
                }
            }
        }

        // فك البيانات قبل الإرسال
        $product->car_model = json_decode($product->car_model);
        $product->year      = json_decode($product->year);
        $product->deleteKey = json_decode($product->deleteKey);
        $product->load('categories');

        return [
            'status'  => true,
            'message' => "Spare Part updated successfully!",
            'data'    => $product,
        ];
    }

    // Updated Function for years
    public function delProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:spare_parts,id', // Validate that the product_id exists in the spare_parts table
        ]);
        try {
            $product = SparePart::findOrFail($request->product_id);

            // // Decode the car_model field if it's a JSON string
            // if (is_string($product->car_model)) {
            //     $carModels = json_decode($product->car_model, true);
            // } else {
            //     $carModels = $product->car_model;
            // }

            // // Ensure car_model is an array
            // if (!is_array($carModels)) {
            //     $carModels = [];
            // }

            // Check if isDelete is true (as string "true")
            // if ($request->isDelete === "true") {
            // Delete the product
            $product->delete();
            return [
                'status'  => true,
                'message' => "Product deleted successfully!",
                'data'    => $this->formatProductData($product),
            ];
            // } else {
            // isDelete is false, proceed with concatenating model_name and year
            // $modelName = $request->model_name;
            // $year = $request->year;

            // if (!empty($modelName) && !empty($year)) {
            //     // Concatenate model_name and year
            //     $concatenatedValue = $modelName . '' . $year;

            //     // Handle the deleteKey field
            //     $deleteKey = $product->deleteKey;

            //     // If deleteKey is a JSON string, decode it, or initialize as an empty array
            //     if (is_string($deleteKey)) {
            //         $deleteKeyArray = json_decode($deleteKey, true);
            //     } else {
            //         $deleteKeyArray = $deleteKey;
            //     }

            //     if (!is_array($deleteKeyArray)) {
            //         $deleteKeyArray = [];
            //     }

            //     // Push the concatenated value into the array
            //     $deleteKeyArray[] = $concatenatedValue;

            //     // Save the updated deleteKey back as a JSON string
            //     $product->deleteKey = json_encode($deleteKeyArray);
            //     $product->save();

            // return [
            //     'status' => true,
            //     'message' => "Product updated with deleteKey!",
            //     'data' => $this->formatProductData($product)
            // ];
            // } else {
            //     return [
            //         'status' => false,
            //         'message' => "Model name or year is missing.",
            //         'data' => null
            //     ];
            // }
            // }
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

        $user = adminAuthModel::whereId($request->user()->id)->update($data);
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
