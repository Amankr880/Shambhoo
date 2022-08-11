<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwilioSMSController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PlanController;

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
    Route::post('/sendSMS', [TwilioSMSController::class, 'index']);
    Route::post('/verifyOtp', [TwilioSMSController::class, 'otpVerify']);  
});
//Route::POST('sendSMS', [App\Http\Controllers\TwilioSMSController::class, 'index']);
// Route::controller(TwilioSMSController::class)->group(function () {
//     Route::post('sendSMS', 'index');
//     Route::post('loginOtp', 'otpVerify');
// });

Route::controller(UserController::class)->group(function () {
    Route::post('createUser', 'create');
    Route::get('showAllUser', 'show');
    Route::post('displaySingleuser', 'displaySingleuser');
    Route::post('updateUserDetail', 'update');
    Route::post('updateUserType', 'updateUserType');
    Route::post('updateUserStatus', 'updateUserStatus');
    Route::post('getMe', 'getMe');
});

Route::controller(CategoriesController::class)->group(function () {
    Route::post('createCategory', 'createCategory');
    Route::get('getAllCategories', 'getAllCategories');
    Route::get('getParentCategory', 'getParentCategory');
    Route::post('getCategoryById/{id}', 'getCategoryById');
    Route::post('updateCategory/{id}', 'updateCategory');
    Route::post('deleteCategory/{id}', 'deleteCategory');
});

Route::controller(ProductController::class)->group(function () {
    Route::post('createProduct', 'createProduct');
    Route::get('getAllProducts', 'getAllProducts');
    Route::post('getProductByCategoryId/{id}', 'getProductByCategoryId');
    Route::post('updateProduct/{id}', 'updateProduct');
    Route::post('deleteProduct/{id}', 'deleteProduct');
});

Route::controller(OrderController::class)->group(function () {
    Route::post('createOrder', 'createOrder');
    Route::get('getOrderByUserId/{id}', 'getOrderByUserId');
    Route::post('updateOrderStatus', 'updateOrderStatus');
});

Route::controller(PaymentController::class)->group(function () {
    Route::post('createPayment', 'createPayment');
});


Route::controller(VendorController::class)->group(function () {
    Route::post('createVendor', 'createVendor');
    Route::post('getVendorByUserId/{id}', 'getVendorByUserId');
    Route::post('updateVendor/{id}', 'createPayment');
});

Route::controller(PlanController::class)->group(function () {
    Route::post('createVendor', 'createVendor');
    Route::post('getVendorByUserId/{id}', 'getVendorByUserId');
    Route::post('updateVendor/{id}', 'createPayment');
});