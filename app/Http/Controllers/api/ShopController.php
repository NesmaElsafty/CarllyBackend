<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\allUsersModel;
use App\Models\carListingModel;
use App\Models\SparePart;
use App\Models\SparePartImage;
use App\Models\SparepartCategory;
use App\Models\CarDealer;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "email"=>'required|email|unique:allusers,email,NULL,id,userType,shop_dealer',
            'fname'=>'required',
            'company_name'=>'required',
            'password'=>'required|min:6',
        ]);

        $user = allUsersModel::create([
            'fname'=> $request['fname'],
            'lname'=> $request['lname'],
            'phone'=> $request['phone'],
            'email'=> $request['email'],
            'city'=> $request['city'] ?? '',
            'lat'=> $request['lat'] ?? '',
            'lng'=> $request['lng'] ?? '',
            'password'=> bcrypt($request['password']),
            "userType"=> "shop_dealer",
        ]);
        $cData=[
            "company_name" => $request->company_name,
            "company_address" => $request->company_address,
            "user_id" => $user->id,
        ];

        if($request->hasFile('company_img')) {
            $img1 = $request->file('company_img');
           $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
           $img1->move(public_path('dealers'), $imgname1);
           $company_img = 'dealers/'.$imgname1;
           $cData['company_img']=$company_img;

        }else {
            $company_img = 'icon/notfound.png';
             $cData['company_img']=$company_img;
        }
        $user->update(['image'=>$cData['company_img']]);

        $user->dealer=CarDealer::create($cData);
        if ($user) {
            return [
                'status' =>true,
                'message' => 'Accounted created Successfully!',
                'data' => [
                    "auth_token"=>$user->createToken('tokens')->plainTextToken,
                    "user" =>$user
                ],
            ];
        }
        else{
            return [
                'status' =>false,
                'message' => 'Password is wronged!',
                'data' => null,
            ];

        }

    }
    public function login(Request $request)
    {
        //    dd(bcrypt('123456'));
        if(isset($request->firebase_auth) && $request->firebase_auth==true){
            return $this->phoneLogin($request);
         }
        $request->validate([
            "email"=>'required|email',
            'password'=>'required'
        ]);

        $user = allUsersModel::where(['email'=> $request['email'], "userType"=> "shop_dealer" ] )
        ->first();
        if($user==null){
            return [
                'status' =>false,
                'message' => 'Email is wronged or not registered!',
                'data' => null,
            ];
        }
        $validCredentials = Hash::check($request['password'], $user->password);
        // dd($user->password);
        if ($validCredentials) {
            return [
                'status' =>true,
                'message' => 'Login Success!',
                'data' => [
                    "auth_token"=>$user->createToken('tokens')->plainTextToken,
                    "user" =>$user
                ],
            ];
        }
        else{
            return [
                'status' =>false,
                'message' => 'Password is wronged!',
                'data' => null,
            ];

        }

    }

    public function phoneLogin(Request $request)
    {

        $request->validate([
            "phone"=>'required',
        ]);

        $user = allUsersModel::where(['phone'=> $request['phone'], "userType"=> "shop_dealer"] )
        ->first();
        if($user==null){
            return [
                'status' =>false,
                'message' => 'Phone is wronged or not registered!',
                'data' => null,
            ];
        }else{
            return [
                'status' =>true,
                'message' => 'Login Success!',
                'data' => [
                    "auth_token"=>$user->createToken('tokens')->plainTextToken,
                    "user" =>$user
                ],
            ];
        }

    }

    public function logout()
    {
        // dd(auth()->user());
        auth()->user()->tokens()->delete();

        return [
           "status"=>true,
           'message' => 'You Logout successfully',
           "data" =>[]
        ];
    }
    public function getProfile(Request $request)
    {
        $user = allUsersModel::with('dealer')->where([
            "id" => auth()->user()->id,
        ])->first();

        return [
            'status' =>true,
            'message' => "Data get successfully!",
            'data' =>  $user,
        ];
    }

    public function getSparepartCategories(Request $request)
    {
        $categories = SparepartCategory::whereNull('parent_id')->get();

        return [
            'status' =>true,
            'message' => "Data get successfully!",
            'data' =>  $categories,
        ];
    }
    public function getSubCategories(Request $request)
    {
        $request->validate([
            "category_id"=>"required"
        ]);
        $categories = SparepartCategory::where('parent_id',$request->category_id)->get();

        return [
            'status' =>true,
            'message' => "Data get successfully!",
            'data' =>  $categories,
        ];
    }

    // public function myProducts(Request $request)
    // {
    //     $spare_parts = SparePart::with('images','category')->where('user_id',auth()->user()->id)->latest('id');

    //     if(isset($request->brand) && $request->brand!='All'){
    //         $spare_parts->where('brand',$request->brand);
    //     }
    //     if(isset($request->priceFrom) && $request->priceFrom!=0){
    //         $spare_parts->where('price','>=',$request->priceFrom);
    //     }
    //     if(isset($request->priceTo) && $request->priceTo!=0){
    //         $spare_parts->where('price','<=',$request->priceTo);
    //     }
    //     if(isset($request->category) && $request->category!='All'){
    //         $spare_parts->where('price','<=',$request->priceTo);
    //     }

    //     $spare_parts =  $spare_parts->paginate(15);

    //         return [
    //             'status' =>true,
    //             'message' => "Data get successfully!",
    //             'data' => [
    //                 "spare_parts" => $spare_parts->items(),
    //                 "pagination"=>[
    //                     'current_page' => $spare_parts->currentPage(),
    //                     'per_page' => $spare_parts->perPage(),
    //                     'total' => $spare_parts->total(),
    //                     'last_page' => $spare_parts->lastPage(),
    //                 ]
    //             ],
    //         ];
    // }
    
    //*****************Updated Function Decoding Array Of Years************************
     public function myProducts(Request $request)
    {
        $spare_parts = SparePart::with('images','category')->where('user_id',auth()->user()->id)->latest('id');

        if(isset($request->brand) && $request->brand!='All'){
            $spare_parts->where('brand',$request->brand);
        }
        if(isset($request->priceFrom) && $request->priceFrom!=0){
            $spare_parts->where('price','>=',$request->priceFrom);
        }
        if(isset($request->priceTo) && $request->priceTo!=0){
            $spare_parts->where('price','<=',$request->priceTo);
        }
        if(isset($request->category) && $request->category!='All'){
            $spare_parts->where('price','<=',$request->priceTo);
        }

        $spare_parts =  $spare_parts->paginate(15);
        $spare_parts->getCollection()->transform(function ($spare_part) {
            $spare_part->year = json_decode($spare_part->year, true);
             if (is_string($spare_part->car_model)) {
            $decodedCarModel = json_decode($spare_part->car_model, true);
            // If decoding results in null and the original string is not an array format, keep the original
            $spare_part->car_model = (is_array($decodedCarModel) || strpos($spare_part->car_model, '[') === false) ? $decodedCarModel : $spare_part->car_model;
        }
         if (is_string($spare_part->deleteKey)) {
            $decodedDeleteKey = json_decode($spare_part->deleteKey, true);
            $spare_part->deleteKey = is_array($decodedDeleteKey) ? $decodedDeleteKey : $spare_part->deleteKey;
        }
            return $spare_part;
        });
            return [
                'status' =>true,
                'message' => "Data get successfully!!",
                'data' => [
                    "spare_parts" => $spare_parts->items(),
                    "pagination"=>[
                        'current_page' => $spare_parts->currentPage(),
                        'per_page' => $spare_parts->perPage(),
                        'total' => $spare_parts->total(),
                        'last_page' => $spare_parts->lastPage(),
                    ]
                ],
            ];
    }
    
    
    
    
    
    

    // public function addProduct(Request $request)
    // {
    //     $validatedData=  $request->validate([
    //         "title" => "required",
    //         // "images"=> "required| array",
    //         "brand"=> "required",
    //         // "model"=> "required",
    //         "year"=> "required",
    //         "part_type"=> "required",
    //         "category_ids"=> "required",
    //         // "price"=> "required|gt:0",
    //     ]);
    //     $validatedData['desc']=$request->desc;
    //     $validatedData+=[
    //         'model'=> $request->model ?? '',
    //         'user_id'    => auth()->user()->id,
    //         'vin_number'    => $request->vin_number ?? '',
    //         'city'    => $request->city ?? '',
    //         'car_model' => json_decode($request->car_model, true),
    //     ];

    //     $category_ids=explode(',',$request->category_ids);
    //     $categories=SparepartCategory::whereIn('id',$category_ids)->get();

    //     if(isset($request->all_categories) && $request->all_categories==true){
    //         $categories=SparepartCategory::all();
    //     }
    //     unset($validatedData['images']);
    //     unset($validatedData['category_ids']);

    //     foreach ($categories as $cat) {
    //         // if($cat!='no'){
    //         $validatedData['title']=$cat->name;
    //         $validatedData['category_id']=$cat->id;
    //         // }
    //         $data= SparePart::create($validatedData);
    //         ////////// handle images start
    //         if($request->images){
    //           foreach ($request->images as $image) {
    //               if ($image) {
    //                   $img1 = $image;
    //                   $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
    //                   $img1->move(public_path('spareparts'), $imgname1);
    //                   $final_img = 'spareparts/'.$imgname1;
    //                     SparePartImage::create([
    //                       "spare_part_id" => $data->id,
    //                       "image" => $final_img,
    //                     ]);
    //               }
    //           }
    //         }else{
    //           SparePartImage::create([
    //               "spare_part_id" => $data->id,
    //               "image" => 'icon/sparepart.jpg',
    //             ]);
    //         }
    //     }



    //     return [
    //         'status' =>true,
    //         'message' => "Spare Part listed successfully!",
    //         'data' => $data
    //     ];
    // }

    //  *****************Updated Function Getting Array Of Years************************

  public function addProduct(Request $request)
{
    $validatedData = $request->validate([
        "title" => "required",
        "brand" => "required",
        'car_model' => "required|array", // Ensure car_model is an array
        "model" => "nullable", 
        "year" => "required|array", // Validate as an array
        "part_type" => "required",
        "category_ids" => "required",
    ]);
    
    // Convert 'car_model' and 'year' arrays to JSON format before storing
    $validatedData['car_model'] = json_encode($request->car_model);
    $validatedData['year'] = json_encode($request->year);
    $validatedData['deleteKey'] = json_encode([]); 
    // $validatedData['desc'] = $request->desc;
    
    $validatedData['desc'] = $request->input('desc', '');
    $validatedData += [
        'user_id' => auth()->user()->id,
        'vin_number' => $request->vin_number ?? '','city' => $request->city ?? '',
    ];

    // Handle categories
    $category_ids = explode(',', $request->category_ids);
    $categories = SparepartCategory::whereIn('id', $category_ids)->get();

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
        $validatedData['title'] = $cat->name;
        $validatedData['category_id'] = $cat->id;
        
        // Create the SparePart record
        $data = SparePart::create($validatedData);

        // Handle images
        if ($request->images) {
            foreach ($request->images as $image) {
                if ($image) {
                    $img1 = $image;
                    $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
                    $img1->move(public_path('spareparts'), $imgname1);
                    $final_img = 'spareparts/' . $imgname1;
                    SparePartImage::create([
                        "spare_part_id" => $data->id,
                        "image" => $final_img,
                    ]);
                }
            }
        } else {
            // Default image if none is provided
            SparePartImage::create([
                "spare_part_id" => $data->id,
                "image" => 'icon/sparepart.jpg',
            ]);
        }
    }

    // Decode 'car_model' and 'year' before returning the response
    if ($data) {
        $data->car_model = json_decode($data->car_model);
        $data->year = json_decode($data->year);
        $data->deleteKey = json_decode($data->deleteKey);
        return [
            'status' => true,
            'message' => "Spare Part listed successfully!",
            'data' => $data,
        ];
    } else {
        // If no categories were found or no data was created
        return [
            'status' => false,
            'message' => "Failed to list the Spare Part. No categories were found or processed.",
        ];
    }
}


    //   public function delProduct(Request $request)
    //         {
    //           $product = SparePart::findOrFail($request->product_id);
    //           $carModels = $product->car_model;
    //           if (is_null($carModels)) {
    //               $product->delete();
    //               return [
    //                  'status' => true,
    //                  'message' => "Product deleted successfully!",
    //                  'data' => $product
    //                   ];
    //             }
    //          if (isset($carModels[$request->carIndex])) {
    //              unset($carModels[$request->carIndex]);
    //           if (empty($carModels)) {
    //               $product->delete();
    //               return [
    //                 'status' => true,
    //                 'message' => "Product deleted successfully!",
    //                 'data' => $product
    //                  ];
    //             } else {
    //               $carModels = array_values($carModels);
    //               $product->car_model = $carModels;
    //               $product->save();
    //               return [
    //                 'status' => true,
    //                 'message' => "Product deleted successfully!",
    //                 'data' => $product
    //                  ];
    //             }
    //          } else {
    //             return [
    //             'status' => false,
    //             'message' => "Invalid car Index. Try again!",
    //              'data' => null
    //               ];
    //           }
    //     }



//  public function delProduct(Request $request)
// {
//     try {
//         // Find the product by ID
//         $product = SparePart::findOrFail($request->product_id);
        
//         // Handle car_model
//         $carModels = $product->car_model;
//         if (is_string($carModels)) {
//             $carModels = json_decode($carModels, true); // Convert JSON string to array
//         }

//         // If car_model is null or not an array, delete the product
//         if (is_null($carModels) || !is_array($carModels)) {
//             $product->delete();
//             return [
//                 'status' => true,
//                 'message' => "Product deleted successfully!",
//                 'data' => $this->formatProductData($product) // Use a helper function to format the data
//             ];
//         }

//         if (isset($carModels[$request->carIndex])) {
//             unset($carModels[$request->carIndex]); // Remove the item at carIndex

//             // If the array is empty after deletion, delete the product
//             if (empty($carModels)) {
//                 $product->delete();
//                 return [
//                     'status' => true,
//                     'message' => "Product deleted successfully!",
//                     'data' => $this->formatProductData($product) // Format the data before returning
//                 ];
//             } else {
//                 // Reindex the array and save it back to the database without json_encode()
//                 $carModels = array_values($carModels); // Reindex the array
//                 $product->car_model = $carModels;      // Save array directly (no json_encode)
//                 $product->save();

//                 return [
//                     'status' => true,
//                     'message' => "Product deleted successfully!",
//                     'data' => $this->formatProductData($product) // Format the data before returning
//                 ];
//             }
//         } else {
//             // Invalid carIndex
//             return [
//                 'status' => false,
//                 'message' => "Invalid car index. Try again!",
//                 'data' => null
//             ];
//         }
//     } catch (\Exception $e) {
//         // Handle any unexpected exceptions
//         return [
//             'status' => false,
//             'message' => "An error occurred: " . $e->getMessage(),
//             'data' => null
//         ];
//     }
// }


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
        if (!is_array($carModels)) {
            $carModels = [];
        }

        // Check if isDelete is true (as string "true")
        if ($request->isDelete === "true") {
            // Delete the product
            $product->delete();
            return [
                'status' => true,
                'message' => "Product deleted successfully!",
                'data' => $this->formatProductData($product)
            ];
        } else {
            // isDelete is false, proceed with concatenating model_name and year
            $modelName = $request->model_name;
            $year = $request->year;

            if (!empty($modelName) && !empty($year)) {
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

                if (!is_array($deleteKeyArray)) {
                    $deleteKeyArray = [];
                }

                // Push the concatenated value into the array
                $deleteKeyArray[] = $concatenatedValue;

                // Save the updated deleteKey back as a JSON string
                $product->deleteKey = json_encode($deleteKeyArray);
                $product->save();

                return [
                    'status' => true,
                    'message' => "Product updated with deleteKey!",
                    'data' => $this->formatProductData($product)
                ];
            } else {
                return [
                    'status' => false,
                    'message' => "Model name or year is missing.",
                    'data' => null
                ];
            }
        }
    } catch (\Exception $e) {
        // Handle any unexpected exceptions
        return [
            'status' => false,
            'message' => "An error occurred: " . $e->getMessage(),
            'data' => null
        ];
    }
}

// public function delProduct(Request $request)
// {
//     $request->validate([
//         'product_id' => 'required|exists:spare_parts,id',
//         'model_name' => 'required|string',
//         'year' => 'required|string',
//     ]);

//     try {
//         $product = SparePart::findOrFail($request->product_id);

//         // Decode the fields if they are JSON strings
//         $carModels = is_string($product->car_model) ? json_decode($product->car_model, true) : $product->car_model;
//         $years = is_string($product->year) ? json_decode($product->year, true) : $product->year;

//         // Ensure the fields are arrays
//         $carModels = is_array($carModels) ? $carModels : [];
//         $years = is_array($years) ? $years : [];

//         $modelName = $request->model_name;
//         $year = $request->year;

//         // Remove the year if specified
//         if (($yearKey = array_search($year, $years)) !== false) {
//             unset($years[$yearKey]);
//         }

//         // Only remove `model_name` if `car_model` has more than one element
//         if (count($carModels) > 1) {
//             if (($key = array_search($modelName, $carModels)) !== false) {
//                 unset($carModels[$key]);
//             }
//         }

//         // Update the fields or delete the product if arrays are empty
//         if (empty($carModels) && empty($years)) {
//             $product->delete();
//             return [
//                 'status' => true,
//                 'message' => "Product deleted successfully!",
//                 'data' => null
//             ];
//         } else {
//             $product->car_model = json_encode(array_values($carModels));
//             $product->year = json_encode(array_values($years));
//             $product->save();

//             return [
//                 'status' => true,
//                 'message' => "Product updated successfully!",
//                 'data' => $this->formatProductData($product)
//             ];
//         }
//     } catch (\Exception $e) {
//         return [
//             'status' => false,
//             'message' => "An error occurred: " . $e->getMessage(),
//             'data' => null
//         ];
//     }
// }




// Helper function to format product data
private function formatProductData($product)
{
    // Decode year if it's a valid JSON string
    if (is_string($product->year)) {
        $decodedYear = json_decode($product->year, true);
        $product->year = (is_array($decodedYear) || strpos($product->year, '[') === false) ? $decodedYear : $product->year;
    }

    // Decode car_model if it's a valid JSON string
    if (is_string($product->car_model)) {
        $decodedCarModel = json_decode($product->car_model, true);
        $product->car_model = is_array($decodedCarModel) ? $decodedCarModel : $product->car_model;
    }
    if (is_string($product->deleteKey)) {
        $decodedDeleteKey = json_decode($product->deleteKey, true);
        $product->deleteKey = is_array($decodedDeleteKey) ? $decodedDeleteKey : $product->deleteKey;
    }
    return $product;
}



    public function updateProfile(Request $request)
    {

       $data=[];
        if($request->name){
            $data['name']=$request->name;
        }
        if($request->email){
            $data['email']=$request->email;
        }
        $image = $request->file('picture');
        if($image){
            $imageName = date('YmdHis') . "_user." . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/'), $imageName);
            $data['picture']=$imageName;
        }
        if($request->address){
            $data['location']=$request->address;
        }
        if($request->lat){
            $data['lat']=$request->lat;
        }
        if($request->lng){
            $data['lng']=$request->lng;
        }
        
        // else{  $imageName ="null";}

        $user=Admin::whereId($request->user()->id)->update($data);
        if($user){
            return [
                'status' =>true,
                'message' => "Profile updated successfully!",
                'data' => [],
            ];
        }
    }

   public function getAllSpareParts(){
  $spareParts = SparePart::all();

return response()->json($spareParts);
   }

}