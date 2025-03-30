<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\BrandResource;
use Illuminate\Http\Request;
use App\Models\Ad;
use Exception;
use Illuminate\Validation\Rule;

class AdController extends Controller
{
    public function index(){
        try{
            $ads = Ad::all();
            return response()->json([
                "data" => AdResource::collection($ads),
            ], 200);
        }catch(Exception $e){
            return response()->json([
                "message" => $e->getMessage(),
            ], 500);
        }
        
    }

    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'caption' => 'required|string',
                'link' => 'required|url',
                'price' => 'required|numeric|min:0',
                'ad_type' => ['required', Rule::in(['cars', 'workshops', 'spare parts'])],
                'appearance_qty' => 'required|integer|min:1',
                'is_active' => 'required|boolean',
                'from' => 'required|date|after_or_equal:today',
                'to' => 'required|date|after:from',
                'views' => 'nullable|integer|min:0',    
                'brand_id' => 'required|integer|in:5,10,15,20,25,30',
                'user_id' => 'required|integer|between:700,750',
            ]);
    
            // Create the Ad
            $ad = Ad::create($validatedData);
    
            // Return response with the created ad
            return response()->json([
                "data" => new AdResource($ad),
            ], 200);
        }catch(Exception $e){
            return response()->json([
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Ad $ad)
    {
        try{
           // Validation Rules
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'caption' => 'sometimes|string',
            'link' => 'sometimes|url',
            'price' => 'sometimes|numeric|min:0',
            'ad_type' => ['sometimes', Rule::in(['cars', 'workshops', 'spare parts'])],
            'appearance_qty' => 'sometimes|integer|min:1',
            'is_active' => 'sometimes|boolean',
            'from' => 'sometimes|date|after_or_equal:today',
            'to' => 'sometimes|date|after:from',
            'views' => 'nullable|integer|min:0',
            'brand_id' => 'sometimes|integer|in:5,10,15,20,25,30',
            'user_id' => 'sometimes|integer|between:700,750',
        ]);

        // Update the Ad
        $ad->update($validatedData);
    
            // Return response with the created ad
            return response()->json([
                "data" => new AdResource($ad),
            ], 200);
        }catch(Exception $e){
            return response()->json([
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Ad $ad)
    {
        // Delete the Ad
        $ad->delete();

        // Return response with success message
        return response()->json([
            'message' => 'Ad deleted successfully.'
        ], 200);
    }

    public function countViews($id)
    {
        try{
           $ad = Ad::find($id);
            $ad->views++;
            $ad->save();
    
            // Return response with the created ad
            return response()->json([
                "data" => new AdResource($ad),
            ], 200);
        }catch(Exception $e){
            return response()->json([
                "message" => $e->getMessage(),
            ], 500);
        }
    }
}
