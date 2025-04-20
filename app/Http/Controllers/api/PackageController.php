<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PackageResource;
use App\Models\RegionalSpec;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Exception;
class PackageController extends Controller
{
    public function index(Request $request){
        try{
            if($request->provider){
                $packages = Package::where('provider',$request->provider)->get();
            }else{
                $packages = Package::get();
            }
            
            return response()->json([
                'status'  => true,
                'message' => PackageResource::collection($packages),
            ], 200);   
           
        }catch(Exception $e){
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);   
        }
    }

    public function getPackages(Request $request)
    {
        $data = Package::latest('id')->paginate(15);

            return [
                'status' =>true,
                'message' => "Data get successfully!",
                'data' => [
                    "items" => PackageResource::collection($data),
                    "pagination"=>[
                        'current_page' => $data->currentPage(),
                        'per_page' => $data->perPage(),
                        'total' => $data->total(),
                        'last_page' => $data->lastPage(),
                    ]
                ]
            ];
    }
    public function addPackage(Request $request)
    {
        $rules=[
            'title' => 'required',
            'provider' => 'required',
            'period' => 'required|min:1',
            'period_type' => 'required',
            'price' => 'required|gt:1',
            'features' => 'required',
            'limits' => 'nullable',
        ];
        if(isset($request->id) &&  $request->id!=''){
            $validatedData=$request->validate($rules);
            $package = Package::findOrFail($request->id);
            // dd($package);
            $package->update($validatedData);
            return [
                'status' =>true,
                'message' => "Package updated successfully!",
                'data' => new  PackageResource($package),
            ];
        }else{
            $validatedData=$request->validate($rules);
           
            $package = Package::create($validatedData);
            return [
                'status' =>true,
                'message' => "Package created successfully!",
                'data' => new  PackageResource($package),
            ];
        }
       

        
    }

    public function delPackage(Request $request)
    {
            $validatedData=$request->validate([
                "id" => "required",
            ]);
            $brand = Package::findOrFail($request->id)->delete();
            return [
                'status' =>true,
                'message' => "Package deleted successfully!",
                'data' => $brand
            ];
    }


 

  

}
