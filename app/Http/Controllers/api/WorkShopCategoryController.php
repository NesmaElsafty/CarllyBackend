<?php

namespace App\Http\Controllers\api;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\WorkshopCategory;
use App\Models\ServiceCategories;
use Illuminate\Http\Request;
use App\Http\Resources\WorkshopCategoryResource;
use Exception;
class WorkShopCategoryController extends Controller
{
    public function addWorkshopCat(Request $request)
    {
      //return $request;
        if (isset($request->category_id) &&  $request->category_id != '') {
            $validatedData = $request->validate([
                'name' => [
                    'required'
                ],
            ]);
            if ($request->hasFile('image')) {
                $img5 = $request->file('image');
                $imgname5 = time() . '.' . $img5->getClientOriginalExtension();
                $img5->move(public_path('workshopCategories'), $imgname5);
                $listing_img5 = 'workshopCategories/' . $imgname5;
                $validatedData['image'] = $listing_img5;
            }

            $brand = WorkshopCategory::find($request->category_id)->update($validatedData);
            return [
                'status' => true,
                'message' => "Workshop Category updated successfully!",
                'data' => $brand
            ];
        } else {
            $validatedData = $request->validate([
                "name" => "required|unique:workshop_categories"
            ]);
            if ($request->hasFile('image')) {
                $img5 = $request->file('image');
                $imgname5 = time() . '.' . $img5->getClientOriginalExtension();
                $img5->move(public_path('spareparts'), $imgname5);
                $listing_img5 = 'spareparts/' . $imgname5;
                $validatedData['image'] = $listing_img5;
            }
            $brand = WorkshopCategory::create($validatedData);
            return [
                'status' => true,
                'message' => "Workshop Category created successfully!",
                'data' => $brand
            ];
        }
    }

    public function getWorkshopCategories(Request $request)
    {
        $data = WorkshopCategory::latest('id');
        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->paginate(15);

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

    public function index(){
        try {
            $categories = WorkshopCategory::all();

            $data = WorkshopCategoryResource::collection($categories);
            return response()->json([
                'data' => $data,
                'statusCode' => 200,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "statusCode" => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function delWorkshopCategory(Request $request)
    {
        $validatedData = $request->validate([
            "category_id" => "required",
        ]);
        $brand = WorkshopCategory::findOrFail($request->category_id)->delete();
        return [
            'status' => true,
            'message' => "Workshop Category deleted successfully!",
            'data' => $brand
        ];
    }
    
    
  // --------------------Working with service categories---------------------------


    public function addServiceCat(Request $request)
    {
        if (isset($request->category_id) &&  $request->category_id != '') {
            $validatedData = $request->validate([
                'name' => [
                    'required',
                    Rule::unique('service_categories')->ignore($request->category_id),
                ],
            ]);
            if ($request->hasFile('image')) {
                $img5 = $request->file('image');
                $imgname5 = time() . '.' . $img5->getClientOriginalExtension();
                $img5->move(public_path('ServicesCategories'), $imgname5);
                $listing_img5 = 'ServicesCategories/' . $imgname5;
                $validatedData['image'] = $listing_img5;
            }

            $brand = ServiceCategories::find($request->category_id)->update($validatedData);
            return [
                'status' => true,
                'message' => "Service Category updated successfully!",
                'data' => $brand
            ];
        } else {
            $validatedData = $request->validate([
                "name" => "required|unique:sparepart_categories"
            ]);
            if ($request->hasFile('image')) {
                $img5 = $request->file('image');
                $imgname5 = time() . '.' . $img5->getClientOriginalExtension();
                $img5->move(public_path('spareparts'), $imgname5);
                $listing_img5 = 'spareparts/' . $imgname5;
                $validatedData['image'] = $listing_img5;
            }
            $brand = ServiceCategories::create($validatedData);
            return [
                'status' => true,
                'message' => "Service Category created successfully!",
                'data' => $brand
            ];
        }
    }


    public function getServicesCategories(Request $request){
        $data = ServiceCategories::whereNull('parent_id')->latest('id');
        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->paginate(15);

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



    public function delServiceCategory(Request $request)
    {
        $validatedData = $request->validate([
            "category_id" => "required",
        ]);
        $brand = ServiceCategories::findOrFail($request->category_id)->delete();
        return [
            'status' => true,
            'message' => "Workshop Category deleted successfully!",
            'data' => $brand
        ];
    }
}
