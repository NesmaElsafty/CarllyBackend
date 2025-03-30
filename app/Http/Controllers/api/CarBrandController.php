<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use App\Http\Resources\BrandResource;
use Exception;
class CarBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $brands = CarBrand::all();
        try {
            $data = BrandResource::collection($brands);
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
}
