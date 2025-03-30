<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\RegionalSpec;
use App\Models\BodyType;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Models\SparepartCategory;
use Exception;
class DataManageController extends Controller
{

    public function getBodyTypes(Request $request)
    {

        $data = BodyType::latest('id')->paginate(15);

        return [
            'status' => true,
            'message' => "Data get successfully!",
            'data' => [
                "items" => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                    'last_page' => $data->lastPage(),
                ]
            ]
        ];
    }
    public function addBodyType(Request $request)
    {
        if (isset($request->id) &&  $request->id != '') {
            $validatedData = $request->validate([
                'name' => [
                    'required',
                ],
            ]);

            $brand = BodyType::find($request->id)->update($validatedData);
            return [
                'status' => true,
                'message' => "BodyType updated successfully!",
                'data' => $brand
            ];
        } else {
            $validatedData = $request->validate([
                "name" => "required"
            ]);

            $brand = BodyType::create($validatedData);
            return [
                'status' => true,
                'message' => "BodyType created successfully!",
                'data' => $brand
            ];
        }
    }

    public function delBodyType(Request $request)
    {
        $validatedData = $request->validate([
            "id" => "required",
        ]);
        $brand = BodyType::findOrFail($request->id)->delete();
        return [
            'status' => true,
            'message' => "BodyType deleted successfully!",
            'data' => $brand
        ];
    }

    public function getRegionalSpecs(Request $request)
    {

        $data = RegionalSpec::latest('id')->paginate(15);

        return [
            'status' => true,
            'message' => "Data get successfully!",
            'data' => [
                "items" => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                    'last_page' => $data->lastPage(),
                ]
            ]
        ];
    }
    public function addRegionalSpecs(Request $request)
    {
        if (isset($request->id) &&  $request->id != '') {
            $validatedData = $request->validate([
                'name' => [
                    'required',
                ],
            ]);

            $brand = RegionalSpec::find($request->id)->update($validatedData);
            return [
                'status' => true,
                'message' => "RegionalSpecs updated successfully!",
                'data' => $brand
            ];
        } else {
            $validatedData = $request->validate([
                "name" => "required"
            ]);

            $brand = RegionalSpec::create($validatedData);
            return [
                'status' => true,
                'message' => "RegionalSpecs created successfully!",
                'data' => $brand
            ];
        }
    }

    public function delRegionalSpecs(Request $request)
    {
        $validatedData = $request->validate([
            "id" => "required",
        ]);
        $brand = RegionalSpec::findOrFail($request->id)->delete();
        return [
            'status' => true,
            'message' => "RegionalSpecs deleted successfully!",
            'data' => $brand
        ];
    }

    public function getSubCategories(Request $request)
    {
        try {
            $request->validate([
                "cat_id" => "required"
            ]);
            $subcategories = SparepartCategory::where('parent_id', $request->cat_id)->get();
            return response()->json(['success' => true, 'data' => $subcategories], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'An error occurred while fetching the data', 'message' => $e->getMessage()], 500);
        }
    }
    public function addSubCategory(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|string|max:255',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('spareparts'), $imageName);
            $dataToUpdate['image'] = 'spareparts/'.$imageName; // Store only the filename
        } else {
            return response()->json(['error' => 'Image upload failed'], 400);
        }
        $subcategory = SparepartCategory::create([
            'name' => $request->input('name'),
            'image' => $imageName,
            'parent_id' => $request->input('category_id'),
        ]);
        return response()->json(['status' => true, 'message' => 'Subcategory added successfully', 'data' => $subcategory], 201);
    }
    public function updateSubcategory(Request $request)
    {
        try {
            $id = $request->input('cat_id');
            $subcategory = SparepartCategory::find($id);

            if (!$subcategory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subcategory not found',
                ], 404);
            }
            $dataToUpdate = [];
            $dataToUpdate['name'] = $request->name;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('spareparts'), $imageName); // Change folder to 'categoriesImages'
                $dataToUpdate['image'] = 'spareparts/' .$imageName;
            }
            $subcategory->update($dataToUpdate);
            return response()->json([
                'status' => true,
                'message' => 'Subcategory updated successfully',
                'subcategory' => $subcategory,
            ], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating the subcategory',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function delSubCategory(Request $request)
    {
        $id = $request->input('cat_id');
        $subCategory = SparepartCategory::where('id', $id)->first();
        if ($subCategory) {
            $subCategory->delete();
            return response()->json([
                'success' => true,
                'message' => 'Subcategory deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Subcategory not found',
            ], $id);
        }
    }

    public function getWebPages(Request $request)
    {
        // $setting = Setting::where('name',['privacy_policy','terms_conditions'])->get()->pluck('value','name')->toArray();
        $setting = Setting::where('name',$request->page)->first();
        return [
            'status' =>true,
            'message' => "pages get successfully!",
            'data' => $setting
        ];
    }

}
