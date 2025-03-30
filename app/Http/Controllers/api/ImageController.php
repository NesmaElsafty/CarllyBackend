<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;

use Exception;
class ImageController extends Controller
{
    public function destroy($id){
        try{
            $image = Image::findOrFail($id);
            $image->delete();

            return response()->json([
                'status' => true,
                'message' => 'Image deleted successfully!',
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }
}
