<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	 
	 //Admin Panel
	 Route::get('/shops', [App\Http\Controllers\AdminController::class, 'getAllShops'])->name('table');
	 Route::get('/shops/{id}', [App\Http\Controllers\AdminController::class, 'getSingleShop'])->name('singleshop');
	 Route::post('updateshop', [App\Http\Controllers\AdminController::class, 'updateShop']);

	 Route::get('/vendors', [App\Http\Controllers\AdminController::class, 'getAllVendors'])->name('allvendors');
	 Route::get('/vendors/{id}', [App\Http\Controllers\AdminController::class, 'getUserDetails'])->name('vendordetails');

	 Route::get('/users', [App\Http\Controllers\AdminController::class, 'getAllUsers'])->name('allusers');
	 Route::get('/users/{id}', [App\Http\Controllers\AdminController::class, 'getUserDetails'])->name('userdetails');
	 Route::post('updateuser', [App\Http\Controllers\AdminController::class, 'updateUser']);

	 Route::get('/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('orders');
	 Route::get('/orders/{id}', [App\Http\Controllers\AdminController::class, 'orderDetails'])->name('orderdetails');
	 Route::post('updateorder', [App\Http\Controllers\AdminController::class, 'updateOrder']);

	 Route::get('/categories', [App\Http\Controllers\AdminController::class, 'allCategories'])->name('allcategories');
	 Route::get('/categories/{id}', [App\Http\Controllers\AdminController::class, 'childCategories'])->name('childcategories');
	 Route::get('/addcategory', [App\Http\Controllers\AdminController::class, 'addCategory'])->name('addcategory');
	 Route::post('addcategory', [App\Http\Controllers\AdminController::class, 'insertCategory']);
	 Route::get('/editcategory/{id}', [App\Http\Controllers\AdminController::class, 'editCategory'])->name('editcategory');
	 Route::post('updatecategory', [App\Http\Controllers\AdminController::class, 'updateCategory']);

	 Route::get('/featuredstores', [App\Http\Controllers\AdminController::class, 'featuredstores'])->name('featuredstores');
	 Route::get('/featuredads', [App\Http\Controllers\AdminController::class, 'featuredads'])->name('featuredads');
});