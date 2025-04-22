<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use App\Http\Resources\BannerResource;
use Illuminate\Support\Facades\Storage;
class BannerController extends Controller
{
    /**
     * Display a listing of banners.
     */
    public function index()
    {
        try {
            // Fetch all banners
            $banners = Banner::all();

            return response()->json([
                'message' => 'Banners retrieved successfully!',
                'data'    => BannerResource::collection($banners),
            ], 200);

        } catch (\Exception $e) {
            // Handle any errors
            return response()->json([
                'message' => 'An error occurred while fetching banners: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created banner in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
        ]);

        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'link'      => 'nullable|string',
            'is_active' => 'required|in:0,1,true,false',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $img     = $request->file('image');
            $imgName = time() . '.' . $img->getClientOriginalExtension();
            $path = Storage::disk('r2')->put('banner/' . $imgName, file_get_contents($img));   


            // $img->move(public_path('banner'), $imgName);
            $bannerImg           = 'banner/' . $imgName;

            // Create a new banner entry in the database
            $banner = Banner::create([
                'name'      => $request->name,
                'image'     => $bannerImg,
                'link'      => $request->link,
                'is_active' => $request->is_active, // Now guaranteed to be a boolean
            ]);


            return response()->json([
                'message' => 'Banner created successfully!',
                'data'    => new BannerResource($banner),
            ], 201);

        } catch (QueryException $e) {
            // Handle database exceptions
            return response()->json([
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);

        }
    }

    public function update(Request $request, Banner $banner)
    {
        // Convert is_active to a boolean manually
        $request->merge([
            'is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
        ]);
    
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'image'     => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link'      => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }
    
        try {
            // Prepare data for update
            $updateData = [
                'name'      => $request->name,
                'link'      => $request->link,
                'is_active' => $request->is_active,
            ];
    
            // If a new image was uploaded, handle file upload
            if ($request->hasFile('image')) {
                // Delete the old image if exists
                if ($banner->image) {
                    $path = public_path($banner->image);

                    if (Storage::disk('r2')->exists($path)) {
                        Storage::disk('r2')->delete($path);
                    }

                    // Storage::disk('public')->delete($banner->image);
                }
                $img     = $request->file('image');
                $imgName = time() . '.' . $img->getClientOriginalExtension();
                $path = Storage::disk('r2')->put('banner/' . $imgName, file_get_contents($img));   

                // $img->move(public_path('banner'), $imgName);
                $bannerImg           = 'banner/' . $imgName;
                 $updateData['image'] = $bannerImg;
            }
    
            // Update the banner in the database
            $banner->update($updateData);
    
            return response()->json([
                'message' => 'Banner updated successfully!',
                'data'    => new BannerResource($banner),
            ], 200);
    
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }
    

    /**
     * Remove the specified banner from storage.
     */
    public function destroy(Banner $banner)
    {
        try {
            $path = public_path($banner->image);    
            if (Storage::disk('r2')->exists($path)) {
                Storage::disk('r2')->delete($path);
            }

            $banner->delete();

            return response()->json([
                'message' => 'Banner deleted successfully!'
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);

        }
    }

    public function getAll(){
        try {
            // Fetch all banners
            $banners = Banner::where('is_active', 'true')->get();

            return response()->json([
                'message' => 'Banners retrieved successfully!',
                'data'    => BannerResource::collection($banners),
            ], 200);

        } catch (\Exception $e) {
            // Handle any errors
            return response()->json([
                'message' => 'An error occurred while fetching banners: ' . $e->getMessage()
            ], 500);
        }
    }
}
