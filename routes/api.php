<?php
use App\Http\Controllers\api\AdController;
use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\allUsersController;
use App\Http\Controllers\api\BannerController;
use App\Http\Controllers\api\CarBrandController;
use App\Http\Controllers\api\carListingController;
use App\Http\Controllers\api\DataManageController;
use App\Http\Controllers\api\DealerController;
use App\Http\Controllers\api\ImageController;
use App\Http\Controllers\api\MessageController;
use App\Http\Controllers\api\PackageController;
use App\Http\Controllers\api\ShopController;
use App\Http\Controllers\api\WorkShopCategoryController;
use App\Http\Controllers\api\WorkShopController;
use App\Http\Controllers\api\FeatureController;
use App\Http\Controllers\api\UserSubscriptionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('getAllSpareParts', [ShopController::class, 'getAllSpareParts']);

///// Admin APIs //////////////
Route::group(['prefix' => 'admin', 'middleware' => 'guest'], function () {

    Route::post('login', [AdminController::class, 'login']);
    //Admin Middleware
    Route::middleware(['auth:sanctum'])->group(function () {
        
        // Your routes here
        Route::post('test', [AdminController::class, 'test']);
        Route::post('registerAdmin', [AdminController::class, 'registerAdmin']);
        Route::get('getAllAdmins', [AdminController::class, 'getAllAdmins']);
        Route::post('delAdmin', [AdminController::class, 'delAdmin']);
        Route::get('getDashboard', [AdminController::class, 'getDashboard']);

        Route::post('getUsers', [AdminController::class, 'getUsers']);

        Route::get('getCarsListing', [AdminController::class, 'getCarsListing']);
        Route::post('delCar', [AdminController::class, 'delCar']);

        Route::get('getSpareParts', [AdminController::class, 'getSpareParts']);
        Route::post('delSparePart', [AdminController::class, 'delSparePart']);

        Route::post('logout', [AdminController::class, 'logout']);
        Route::post('userAccStatus', [AdminController::class, 'userAccStatus']);

        Route::post('getUserDetails', [AdminController::class, 'getUserDetails']);

        Route::post('addBrand', [AdminController::class, 'addBrand']);
        Route::post('delBrand', [AdminController::class, 'delBrand']);
        Route::post('delModel', [AdminController::class, 'delModel']);
        Route::post('delYear', [AdminController::class, 'delYear']);

        Route::post('addBrandModel', [AdminController::class, 'addBrandModel']);
        Route::post('addModelYear', [AdminController::class, 'addModelYear']);

        Route::get('getBrandModels', [AdminController::class, 'getBrandModels']);
        Route::get('getModelYears', [AdminController::class, 'getModelYears']);

        Route::get('getAllBrands', [AdminController::class, 'getAllBrands']);
        Route::get('getAllModels', [AdminController::class, 'getAllModels']);
        Route::get('getAllYears', [AdminController::class, 'getAllYears']);

        Route::post('addCategory', [AdminController::class, 'addCategory']);
        Route::post('delCategory', [AdminController::class, 'delCategory']);
        Route::post('delWorkshopCategory', [WorkShopCategoryController::class, 'delWorkshopCategory']);
        Route::get('getSparepartCategories', [AdminController::class, 'getSparepartCategories']);

        Route::get('getSettings', [AdminController::class, 'getSettings']);
        Route::post('updateSettings', [AdminController::class, 'updateSettings']);

        Route::get('getSubCategories', [DataManageController::class, 'getSubCategories']);
        Route::post('addSubCategory', [DataManageController::class, 'addSubCategory']);
        Route::post('updateSubcategory', [DataManageController::class, 'updateSubcategory']);
        Route::post('delSubCategory', [DataManageController::class, 'delSubCategory']);

        Route::get('getBodyTypes', [DataManageController::class, 'getBodyTypes']);
        Route::post('addBodyType', [DataManageController::class, 'addBodyType']);
        Route::post('delBodyType', [DataManageController::class, 'delBodyType']);

        Route::get('getRegionalSpecs', [DataManageController::class, 'getRegionalSpecs']);
        Route::post('addRegionalSpecs', [DataManageController::class, 'addRegionalSpecs']);
        Route::post('delRegionalSpecs', [DataManageController::class, 'delRegionalSpecs']);
        Route::get('getWorkshopCategories', [WorkShopCategoryController::class, 'getWorkshopCategories']);
        // Route::get('getPackages', [PackageController::class, 'getPackages']);
        // Route::post('addPackage', [PackageController::class, 'addPackage']);
        // Route::post('delPackage', [PackageController::class, 'delPackage']);
        Route::post('create/WorkshopCat', [WorkShopCategoryController::class, 'addWorkshopCat']);

        // -----------Service Categories---------------
        Route::post('addServiceCat', [WorkShopCategoryController::class, 'addServiceCat']);
        Route::get('getServicCategories', [WorkShopCategoryController::class, 'getServicesCategories']);
        Route::post('delServiceCategory', [WorkShopCategoryController::class, 'delServiceCategory']);

        Route::resource('ads', AdController::class);
        Route::get('countViews/{id}', [AdController::class, 'countViews']);

        Route::resource('banners', BannerController::class);
        Route::post('/banners/{banner}', [BannerController::class, 'update']);

        Route::resource('features', FeatureController::class);


    });
});

//General APIs
Route::get('getBrandsList', [DealerController::class, 'getBrandsList']);
Route::get('getBrandModels', [DealerController::class, 'getBrandModels']);
Route::get('getModelYears', [DealerController::class, 'getModelYears']);
Route::get('getRegionalSpecs', [DealerController::class, 'getRegionalSpecs']);
Route::get('getBodyTypes', [DealerController::class, 'getBodyTypes']);
Route::get('getSparepartCategories', [ShopController::class, 'getSparepartCategories']);
Route::get('getWorkshopServices', [WorkShopController::class, 'getWorkshopServices']);

Route::get('getSubCategories', [ShopController::class, 'getSubCategories']);
Route::get('getSupportDetails', [DealerController::class, 'getSupportDetails']);
Route::get('getWebPages', [DataManageController::class, 'getWebPages']);
Route::get('getPages', [DealerController::class, 'getPages']);

Route::get('getWorkshopCategories', [WorkShopController::class, 'getWorkshopCategories']);
Route::get('workshop/{workshop_id}', [WorkShopController::class, 'show']);

Route::get('getAllBanners', [BannerController::class, 'getAll']);

///// Car Dealer APIs //////////////
Route::group(['prefix' => 'dealer', 'middleware' => 'guest'], function () {
    Route::post('login', [DealerController::class, 'login']);
    Route::post('register', [DealerController::class, 'register']);
    //Dealer Middleware
    Route::middleware(['auth:sanctum', 'DealerAuth'])->group(function () {
        // Your routes here
        // Route::get('getCarsListing', [DealerController::class,'getCarsListing']);
        Route::get('getProfile', [DealerController::class, 'getProfile']);
        Route::get('myCarsListing', [DealerController::class, 'myCarsListing']);
        Route::post('addCarListing', [DealerController::class, 'addCarListing']);
        Route::post('editCarListing', [DealerController::class, 'editCarListing']);
        Route::post('delCar', [DealerController::class, 'delCar']);
        Route::post('carUploadImgs', [DealerController::class, 'carUploadImgs']);
        Route::delete('delImg/{id}', [DealerController::class, 'delImg']);

        Route::post('logout', [DealerController::class, 'logout']);
    });
});

// Spare Parts Dealer
Route::group(['prefix' => 'shop', 'middleware' => 'guest'], function () {
    Route::post('login', [ShopController::class, 'login']);
    Route::post('register', [ShopController::class, 'register']);
    //Dealer Middleware
    Route::middleware(['auth:sanctum', 'ShopAuth'])->group(function () {
        // Your routes here
        Route::get('myProducts', [ShopController::class, 'myProducts']);
        Route::post('addProduct', [ShopController::class, 'addProduct']);
        Route::post('delProduct', [ShopController::class, 'delProduct']);
        Route::get('getProfile', [ShopController::class, 'getProfile']);
        Route::post('logout', [ShopController::class, 'logout']);
    });
});

// Workshop Dealer
Route::group(['prefix' => 'workshop', 'middleware' => 'guest'], function () {
    Route::post('login', [WorkShopController::class, 'login']);
    Route::post('register', [WorkShopController::class, 'register']);
    //workshop Middleware
    Route::middleware(['auth:sanctum', 'WorkshopAuth'])->group(function () {
        // Your routes here
        Route::get('myCustomers', [WorkShopController::class, 'myCustomers']);
        Route::post('addCustomer', [WorkShopController::class, 'addCustomer']);
        Route::post('delCustomer', [WorkShopController::class, 'delCustomer']);

        Route::post('uploadWorkshopImages', [WorkShopController::class, 'uploadWorkshopImages']);

        Route::get('getAllInvoices', [WorkShopController::class, 'getAllInvoices']);
        Route::post('createInvoice', [WorkShopController::class, 'createInvoice']);
        Route::get('getProfile', [WorkShopController::class, 'getProfile']);
        Route::post('wsUploadImgs', [WorkShopController::class, 'wsUploadImgs']);
        Route::delete('wsDelImg/{id}', [WorkShopController::class, 'wsDelImg']);

        Route::post('logout', [WorkShopController::class, 'logout']);

        Route::get('getAllServiceCat', [WorkShopCategoryController::class, 'getServicesCategories']);

        Route::post('addservice', [WorkShopController::class, 'addworkshopservice']);
        Route::get('getAllServices', [WorkShopController::class, 'getAllServices']);
        Route::post('delService', [WorkShopController::class, 'delService']);

        //---------------Manage workshop customers  Cars ------------------------
        Route::post('/addCar', [WorkShopController::class, 'addCar']);
        Route::get('/getAllCars', [WorkShopController::class, 'getAllCars']);
        Route::post('/deleteCar', [WorkShopController::class, 'delCars']);

        //---------------Manage workshop customers service------------------------
        Route::post('/addCustomerService', [WorkShopController::class, 'addCustomerService']);
        Route::get('/getAllCustomerServices', [WorkShopController::class, 'getAllCustomerServices']);
        Route::post('/deleteCustomerService', [WorkShopController::class, 'deleteCustomerService']);

        //---------------Manage workshop expense------------------------
        Route::post('/addExpense', [WorkShopController::class, 'addWorkshopExpense']);
        Route::get('/getAllExpense', [WorkShopController::class, 'getWorkshopExpense']);
        Route::post('/deleteExpense', [WorkShopController::class, 'deleteWorkshopExpense']);

        //---------------Manage workshop Appointment------------------------
        Route::post('/addAppointment', [WorkShopController::class, 'addAppointment']);
        Route::get('/getAllAppointments', [WorkShopController::class, 'getAllAppointments']);
        Route::post('/deleteAppointment', [WorkShopController::class, 'deleteAppointment']);

        //  ------------------Update Workshop, ws Brands and Categories--------------------------
        Route::post('/update', [WorkShopController::class, 'update']);
        Route::post('/brands', [WorkShopController::class, 'workShopBrands']);
        Route::post('/categories', [WorkShopController::class, 'workShopCategories']);

    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Your routes here
    Route::post('updateProfile', [DealerController::class, 'updateProfile']);
    Route::post('seller/updateProfile', [DealerController::class, 'updateProfile']);
    Route::get('getCurrentUser', [allUsersController::class, 'getCurrentUser']);

    Route::resource('images', controller: ImageController::class);
    
    //For User APP
    Route::post('addCarListing', [carListingController::class, 'addCarListing']);
    Route::post('editCarListing', [carListingController::class, 'editCarListing']);
    Route::post('myCarsListing', [carListingController::class, 'myCarsListing']);
    Route::post('delCar', [carListingController::class, 'delCar']);
    Route::get('getChatMessages', [MessageController::class, 'getChatMessages']);
    Route::get('getRecentChats', [MessageController::class, 'getRecentChats']);
    Route::post('sendMessage', [MessageController::class, 'sendMessage']);
    Route::post('uploadImgs', [carListingController::class, 'uploadImgs']);
    Route::delete('delImg/{id}', [carListingController::class, 'delImg']);

    Route::post('deleteUser', [allUsersController::class, 'deleteUser']);

    // Subscription
        Route::post('/subscribe', [UserSubscriptionController::class, 'subscribe']);
        Route::post('/renew', [UserSubscriptionController::class, 'renew']);
        Route::post('/upgrade', [UserSubscriptionController::class, 'upgrade']);
        Route::post('/cancel', [UserSubscriptionController::class, 'cancel']);
        Route::get('/history', [UserSubscriptionController::class, 'history']);
});

// WorkShop Provider
Route::get('brands', [CarBrandController::class, 'index']);
Route::get('categories', [WorkshopCategoryController::class, 'index']);
Route::post('workshops', [WorkShopController::class, 'index']);
Route::Resource('packages', PackageController::class);


Route::post('login', [allUsersController::class, 'login']);
Route::post('register', [allUsersController::class, 'register']);

Route::get('getAllCarsListing', [AdminController::class, 'getCarsListing']);
Route::get('searchSpareParts', [allUsersController::class, 'searchSpareParts']);

//New Apis for deep linking
Route::get('getCarListingById/{id}', [carListingController::class, 'getCarListingById']);
Route::get('getSparePartsById/{id}', [carListingController::class, 'getSparePartsById']);


Route::get('/share/workshop', function (Request $request) {
    $workshopId = $request->query('id');

    $userAgent = strtolower($request->header('User-Agent'));
    $isMobile = str_contains($userAgent, 'android') || str_contains($userAgent, 'iphone');

    if ($isMobile) {
        $baseUrl = env('APP_URL');
        return redirect($baseUrl."/workshop/$workshopId");
    }

    return response("Please open this link on your mobile device.", 200);
});