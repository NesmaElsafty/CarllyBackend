<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    public function index(Request $request): JsonResponse
    {
        try {
            $packages = Package::query();

            if ($request->has('provider')) {
                $packages->where('provider', $request->provider);
            }

            $packages = $packages->latest()->get();
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
        }catch(Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(PackageRequest $request): JsonResponse
    {
        try {
            $data = $request->except('feature_ids');

            // خزّن البيانات الأساسية
            $package = Package::create($data);

            $package->features()->attach($request->feature_ids);

            return response()->json([
                'success' => true,
                'message' => 'Package created successfully',
                'data'    => new PackageResource($package),
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $package = Package::findOrFail($id);
            return response()->json([
                'success' => true,
                'data'    => new PackageResource($package),
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 404);
        }
    }

    public function update(PackageRequest $request, string $id): JsonResponse
    {
        try {
            $package = Package::findOrFail($id);
            $package->update($request->except('feature_ids'));

            // sync features
            $package->features()->sync($request->feature_ids);

            return response()->json([
                'success' => true,
                'message' => 'Package updated successfully',
                'data'    => new PackageResource($package),
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $package = Package::findOrFail($id);
            $package->delete();
            return response()->json([
                'success' => true,
                'message' => 'Package deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
