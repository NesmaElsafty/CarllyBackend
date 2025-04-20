<?php 
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRequest;
use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use DB;

class FeatureController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $features = Feature::latest()->get();
            return response()->json([
                'success' => true,
                'data' => FeatureResource::collection($features),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch features',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(FeatureRequest $request): JsonResponse
    {
        try {
            $feature = Feature::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Feature created successfully',
                'data' => new FeatureResource($feature),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Feature creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $feature = Feature::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => new FeatureResource($feature),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Feature not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(FeatureRequest $request, string $id): JsonResponse
    {
        try {
            $feature = Feature::findOrFail($id);
            $feature->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Feature updated successfully',
                'data' => new FeatureResource($feature),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Feature update failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $feature = Feature::findOrFail($id);
            $feature->delete();

            return response()->json([
                'success' => true,
                'message' => 'Feature deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Feature deletion failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
