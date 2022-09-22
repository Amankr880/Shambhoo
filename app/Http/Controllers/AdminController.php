<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Categories;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\order_Item;
use Storage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    //Vendor Management
    public function getAllVendors(){
        $vendors = User::where('user_type','=',1)->select('users.id','users.first_name','users.last_name','users.user_status','users.user_type','users.email','users.image')->get();
        return view('pages.allvendors',['vendors'=>$vendors]);
    }

    //User Management
    public function getAllUsers(){
        $users = User::where('user_type','!=',1)->orWhereNull('user_type')->select('users.id','users.first_name','users.last_name','users.user_status','users.email','users.phone_no')->get();
        return view('pages.allusers',['users'=>$users]);
    }
    public function getUserDetails($id){
        $user=User::where('id','=',$id)->select('*')->get()->toarray();
        return view('pages.userdetails',['user'=>$user]);
    }
    public function updateUser(Request $request){

        $image=$request['image'];
        echo $request->file('image_file');
        if($request->file('image_file')!=""){
            $destinationPath = "assets/img/users";
            if($image!="")
                Storage::disk('public')->delete($destinationPath.'/'.$request['image']);
            $image=$request->file('image_file')->hashName();
            $filename = 'http://shambhoo.herokuapp.com/storage/assets/img/users/'. $image;
            Storage::disk('public')->putFileAs($destinationPath,$request->file('image_file'),$image);
        }

        $user  = User::findOrFail($request['id']);
        $input = $request->all();
        $user->fill($input);
        $user['image']=$filename;
        $user->save();
        return redirect()->route('userdetails', ['id' => $request['id']]);
    }


    //Shop Management
    public function getAllShops(Request $request){
        $shops = Vendor::join('users','vendors.user_id', '=', 'users.id')->select('vendors.id','vendors.shopName','vendors.status','vendors.visibility','vendors.logo_image','users.first_name','users.last_name')->get();
        return view('pages.shops',['shops'=>$shops]);
    }
    public function getSingleShop($id){
        $shop = Vendor::join('users','vendors.user_id', '=', 'users.id')->where('vendors.id','=',$id)->select('vendors.*','users.first_name','users.last_name')->get()->toarray();
        return view('pages.shopdetails',['shop'=>$shop]);
    }
    public function updateShop(Request $request){
        echo $request;
        $shop  = Vendor::findOrFail($request['id']);
        $input = $request->all();
        $shop->fill($input)->save();
        return redirect()->route('singleshop', ['id' => $request['id']]);
    }


    //Order Management
    public function orders(){
        $orders = Order::join('users','order.user_id', '=', 'users.id')->join('vendors','order.vendor_id', '=', 'vendors.id')->select('order.id','order.order_no','order.order_status','order.total_order','users.first_name','users.last_name','vendors.shopName')->get();
        return view('pages.orders',['orders'=>$orders]);
    }
    public function orderDetails($id){
        $orderDetails = Order::where('id','=',$id)->select('order.*')->get()->toarray();
        return view('pages.orderdetails',['orderDetails'=>$orderDetails]);
    }
    public function updateOrder(Request $request){
        //echo $request['id'];
        $order  = Order::findOrFail($request['id']);
        $input = $request->all();
        $order->fill($input)->save();
        return redirect()->route('orderdetails', ['id' => $request['id']]);
    }

    //Category Management   
    public function allCategories(){
        $allCategories=Categories::where('parent_category','=',NULL)->get();
        return view('pages.allcategories',['allcategories'=>$allCategories]);
    }
    public function childCategories($id){
        $allCategories=Categories::where('parent_category','=',$id)->get();
        $parent=Categories::where('id','=',$id)->select('id','category_name')->get();

        return view('pages.allcategories',['allcategories'=>$allCategories,'parent'=>$parent]);
    }
    public function addCategory(){
        $category = collect(Categories::first())->keys();
        $parent_categories = Categories::where('parent_category','=',NULL)->select('id','category_name')->get();
        return view('pages.addcategory',['category'=>$category,'parent_categories'=>$parent_categories]);
    }
    public function insertCategory(Request $request){
    
        $icon="";
        if($request->file('icon_file')!=""){
            $destinationPath = "assets/img/category_icons";
            $icon=$request->file('icon_file')->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$request->file('icon_file'),$icon);
        }
        $insert = new Categories;
        $insert->fill($request->all());
        $insert['icon']=$icon;
        $insert->save();
        $allCategories=Categories::where('parent_category','=',NULL)->get();
        return view('pages.allcategories',['allcategories'=>$allCategories]);
    }
    public function editCategory($id){
        $category = Categories::where('id','=',$id)->select('*')->get()->toarray();
        $parent_categories = Categories::where('parent_category','=',NULL)->select('id','category_name')->get();
        return view('pages.editcategory',['category'=>$category,'parent_categories'=>$parent_categories]);
    }
    public function updateCategory(Request $request){

        $icon=$request['icon_hash'];
        if($request->file('icon_file')!=""){
        $destinationPath = "assets/img/category_icons";
        $icon=$request->file('icon_file')->hashName();
        Storage::disk('public')->delete($destinationPath.'/'.$request['icon_hash']);
        Storage::disk('public')->putFileAs($destinationPath,$request->file('icon_file'),$icon);
        }
        $category  = Categories::findOrFail($request['id']);
        $input = $request->all();
        $category->fill($input);
        $category['icon']=$icon;
        $category->save();
        return redirect()->route('editcategory', ['id' => $request['id']]);
    }
}
