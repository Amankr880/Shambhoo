<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/sendSMS', [SMSController::class, 'index']);
    Route::post('/sendSMSTest', [SMSController::class, 'smsSend']);
    Route::post('/verifyOtp', [SMSController::class, 'otpVerify']);  
});
//Route::POST('sendSMS', [App\Http\Controllers\TwilioSMSController::class, 'index']);
// Route::controller(TwilioSMSController::class)->group(function () {
//     Route::post('sendSMS', 'index');
//     Route::post('loginOtp', 'otpVerify');
// });

Route::controller(UserController::class)->group(function () {
    Route::post('createUser', 'userCreate');
    Route::get('showAllUser', 'show');
    Route::post('displaySingleuser', 'displaySingleuser');
    Route::post('updateUserDetail', 'update');
    Route::post('updateUserType', 'updateUserType');
    Route::post('updateUserStatus', 'updateUserStatus');
    Route::get('getMe', 'getMe');
    Route::post('updateAddress', 'updateAddress');
});

Route::controller(CategoriesController::class)->group(function () {
    Route::post('createCategory', 'createCategory');
    Route::get('getAllCategories', 'getAllCategories');
    Route::post('getParentCategory', 'getParentCategory');
    Route::post('getCategoryById', 'getCategoryById');
    Route::post('updateCategory/{id}', 'updateCategory');
    Route::post('deleteCategory/{id}', 'deleteCategory');
});

Route::controller(ProductController::class)->group(function () {
    Route::post('createProduct', 'createProduct');
    Route::get('getAllProducts', 'getAllProducts');
    Route::post('getProductByCategoryId', 'getProductByCategoryId');
    Route::post('getSingleProduct', 'getSingleProduct');
    Route::post('updateProduct/{id}', 'updateProduct');
    Route::post('deleteProduct/{id}', 'deleteProduct');
    Route::post('getVendorCategory', 'getVendorCategory');
});

Route::controller(OrderController::class)->group(function () {
    Route::post('createOrder', 'createOrder');
    Route::get('getOrderByUserId/{id}', 'getOrderByUserId');
    Route::post('updateOrderStatus', 'updateOrderStatus');
});

Route::controller(PaymentController::class)->group(function () {
    Route::post('createPayment', 'createPayment');
});

Route::controller(ReviewsController::class)->group(function () {
    Route::post('createReview', 'createReview');
    Route::post('getReview', 'getReview');
});

Route::controller(HomeController::class)->group(function () {
    Route::post('featureImageUpload', 'featureImageUpload');
    Route::get('featureImageShow', 'featureImageShow');
    Route::post('getStore', 'getStore');
    Route::post('getFeatureStore', 'getFeatureStore');
    Route::post('getSingleStore', 'getSingleStore');
});

Route::controller(CartController::class)->group(function () {
    Route::post('addProduct', 'addProduct');
    // Route::get('featureImageShow', 'featureImageShow');
    // Route::post('getStore', 'getStore');
    // Route::post('getFeatureStore', 'getFeatureStore');
});


Route::controller(VendorController::class)->group(function () {
    Route::post('createVendor', 'createVendor');
    Route::post('getVendorByUserId/{id}', 'getVendorByUserId');
    Route::post('updateVendor/{id}', 'updateVendor');
    Route::post('getVendor', 'getVendor');
});

// Route::controller(PlanController::class)->group(function () {
//     Route::post('createVendor', 'createVendor');
//     Route::post('getVendorByUserId/{id}', 'getVendorByUserId');
//     Route::post('updateVendor/{id}', 'createPayment');
// });

Route::get('image/{filename}', 'HomeController@displayImage');