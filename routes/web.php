<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\adminAuthController;
use App\Http\Controllers\admin\carListingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/






Route::post('admlogin', [adminAuthController::class, 'adminloginf'])->name('admlogin');
Route::delete('/car/{id}', [carListingController::class, 'deleteListingF'])->name('car.delete');

Route::get('/home', function () {
    return view('home');
})->name('home');


Route::get('/carsilla', function () {
    return view('adminlogin');
})->name('carsilla');
/////////////////////////////////

Route::get('/onic4', function () {
    return view('tempfile');
});

Route::get('/lmra', function () {
    return view('tempfile2');
});
Route::get('/app/lmra',function(){
    return view('tempfile3');
});
Route::get('/lmra/app',function(){
    return view('tempfile6');
});
Route::get('/onicapps',function(){
    return view('tempfile4');
});
Route::get('/tra',function(){
    return view('tempfile5');
});
/////////////////////////////////////////////

Route::get('/', function () {
    return view('welcome');
});

//////////////////////
////////// for admin panel start
// Route::get('/wizostamp/login',  [adminAuthController::class, 'getLoginPageF'] );
// Route::post('/wizostamp/login', [adminAuthController::class, 'adminLoginF'])->name('loginpost');;
////////// for admin panel end




//////////////////////////////////////////////////////////////////////////
/////////// for clear cache 
Route::get('/clear/cache', function () {
    $run = Artisan::call('config:clear');
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('config:cache');
    $run = Artisan::call('route:clear');

    // $run = Artisan::call('view:clear');
    return 'Cleard';
});
//////////////////////////////////////////////////////////////////////////