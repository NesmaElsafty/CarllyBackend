<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\carListingModel;
use App\Http\Controllers\Controller;
use App\Models\admin\adminAuthModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class adminAuthController extends Controller
{
      //for admin login 
      public function adminloginf(Request $request){
        $validator = Validator::make($request->all(), [
            'loginemail' => 'required|email',
            'loginpassword' => 'required',
            // 'id',
            // 'name',
            // 'email',
            // 'pass',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $dataofauth = adminAuthModel::where('email', $request->loginemail)->first();
            if ($dataofauth) {
                if ($request->loginpassword === $dataofauth->pass) {
                    $carListings = carListingModel::all();
                    $carListings = $carListings->isEmpty() ? [] : $carListings;
                    return view('home')->with('carListings', $carListings)->with('greentoast', 'Login Successful.');
                
                    // return redirect()->route('home', ['carListing' => $carListings])->with('greentoast', 'Login Successful.');
                }else{
                    return redirect()->route('carsilla')->with('redtoast', 'Invalid Password.');
                } 
                // $hashedPassword = Hash::make(1234);
                // if (Hash::check($request->loginpassword, $dataofauth->password) && $dataofauth->role == 'admin') {
                //     $auth_data_ses = [
                //         'isauthlogin' => 1,
                // //     ];
                //     Session::put('auth_data_ses', $auth_data_ses);
                // } else {
                // }
            } else {
                return redirect()->route('carsilla')->with('redtoast', 'Credential not found.');
            }
        }
    }
    
}