<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\carListingModel;
use App\Http\Controllers\Controller;

class carListingController extends Controller
{
   public function deleteListingF ($id){
        $check = carListingModel::find($id);
        $check->delete();
        $carListings = carListingModel::all();
        return view('home')->with('carListings', $carListings)->with('greentoast', 'Car Listing Item Deleted.');
    
    }
}