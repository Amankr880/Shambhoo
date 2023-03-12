<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Categories;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Ads;
use App\Models\order_Item;
use Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{

    //Vendor Management
    public function getAllVendors(Request $request){
        $vendors = User::where('user_type','=',1)->select('users.id','users.first_name','users.last_name','users.user_status','users.phone_no','users.user_type','users.email','users.image');
        if($request['search'])
            $vendors=$vendors->where('phone_no','LIKE','%'.$request['search'].'%');
        $vendors=$vendors->get();
        return view('pages.allvendors',['vendors'=>$vendors]);
    }

    //User Management
    public function getAllUsers(Request $request){
        $users = User::where('user_type','!=',1)->select('users.id','users.first_name','users.last_name','users.user_status','users.email','users.phone_no');
        if($request['search']){
            $users=$users->where('phone_no','LIKE','%'.$request['search'].'%');
        }
        $users=$users->get();
        return view('pages.allusers',['users'=>$users]);
    }
    public function getUserDetails($id){
        $user=User::where('id','=',$id)->select('*')->get()->toarray();
        $products=[];
        if($user[0]['user_type']==1){
            $products=Product::where('vendor_id','=',$user[0]['id'])->select('*')->get()->toarray();
        }
        return view('pages.userdetails',['user'=>$user,'products'=>$products]);
    }
    public function updateUser(Request $request){

        $image=$request['image'];
        $file=$request->file('image_file');
        if($file!=""){
            $destinationPath = "assets/img/users/";
            if($image!="")
                Storage::disk('public')->delete($destinationPath.$request['image']);
            $image=$file->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$file,$image);
        }

        $user  = User::findOrFail($request['id']);
        $input = $request->all();
        $user->fill($input);
        $user['image']=$image;
        $user->save();
        return redirect()->route('allusers');
    }


    //Shop Management
    public function getAllShops(Request $request){
        $shops = Vendor::join('users','vendors.user_id', '=', 'users.id')->select('vendors.id','vendors.user_id','vendors.shopName','vendors.status','vendors.visibility','vendors.logo_image','users.first_name','users.last_name')->get();
        return view('pages.shops',['shops'=>$shops]);
    }
    public function getSingleShop($id){
        $shop = Vendor::join('users','vendors.user_id', '=', 'users.id')->where('vendors.id','=',$id)->leftJoin('plan_subscriptions','vendors.id','=','plan_subscriptions.vendor_id')->select('vendors.*','plan_subscriptions.validity','users.first_name','users.last_name')->get()->toarray();
        $products = Product::where('vendor_id','=',$id)->select('products.product_name','products.product_desc','products.picture')->get()->toarray();
        return view('pages.shopdetails',['shop'=>$shop,'products'=>$products]);
    }
    public function updateShop(Request $request){

        //ID Proof
        $id_proof_photo=$request['id_proof_photo'];
        $file=$request->file('id_proof_photo_file');
        if($file!=""){
            $destinationPath = "assets/img/id_proof/";
            if($id_proof_photo!="")
                Storage::disk('public')->delete($destinationPath.$id_proof_photo);
            $id_proof_photo=$file->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$file,$id_proof_photo);
        }

        //Pancard
        $pancard_photo=$request['pancard_photo'];
        $file=$request->file('pancard_photo_file');
        if($file!=""){
            $destinationPath = "assets/img/pancard/";
            if($pancard_photo!="")
                Storage::disk('public')->delete($destinationPath.$pancard_photo);
            $pancard_photo=$file->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$file,$pancard_photo);
        }

        //Business Doc Photo
        $business_doc_photo=$request['business_doc_photo'];
        $file=$request->file('business_doc_photo_file');
        if($file!=""){
            $destinationPath = "assets/img/business_doc/";
            if($business_doc_photo!="")
                Storage::disk('public')->delete($destinationPath.$business_doc_photo);
            $business_doc_photo=$file->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$file,$business_doc_photo);
        }

        //Header Image
        $header_image=$request['header_image'];
        $file=$request->file('header_image_file');
        if($file!=""){
            $destinationPath = "assets/img/header/";
            if($header_image!="")
                Storage::disk('public')->delete($destinationPath.$header_image);
            $header_image=$file->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$file,$header_image);
        }

        //Gallery Image
        $gallery_image=$request['gallery'];
        $file=$request->file('gallery_file');
        if($file!=""){
            $destinationPath = "assets/img/gallery/";
            if($gallery_image!="")
                Storage::disk('public')->delete($destinationPath.$gallery_image);
            $gallery_image=$file->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$file,$gallery_image);
        }

        //Logo
        $logo_image=$request['logo_image'];
        $file=$request->file('logo_image_file');
        if($file!=""){
            $destinationPath = "assets/img/logo/";
            if($logo_image!="")
                Storage::disk('public')->delete($destinationPath.$logo_image);
            $logo_image=$file->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$file,$logo_image);
        }

        $shop  = Vendor::findOrFail($request['id']);
        $input = $request->all();
        $input['id_proof_photo']=$id_proof_photo;
        $input['pancard_photo']=$pancard_photo;
        $input['business_doc_photo']=$business_doc_photo;
        $input['logo_image']=$logo_image;
        $input['header_image']=$header_image;
        $input['gallery']=$gallery_image;
        $shop->fill($input)->save();
        return redirect()->route('table');
    }

    public function featuredstores(){
        $featuredstores =Vendor::join('users','vendors.user_id', '=', 'users.id')->where('status','=',3)->select('vendors.id','vendors.shopName','vendors.status','vendors.visibility','vendors.logo_image','users.first_name','users.last_name')->get();
        $eligible =Vendor::join('users','vendors.user_id', '=', 'users.id')->where('status','=',2)->select('vendors.id','vendors.shopName','vendors.status','vendors.visibility','vendors.logo_image','users.first_name','users.last_name')->get();
        return view('pages.featuredstores',['featuredstores'=>$featuredstores,'eligible'=>$eligible]);
    }
    public function featuredads(){
        $featuredads=Ads::select('*')->get();
        return view('pages.featuredads',['featuredads'=>$featuredads]);
    }
    public function editads($id){
        $featuredads=Ads::where('id','=',$id)->select('*')->get()->toarray();
        return view('pages.editads',['featuredads'=>$featuredads]);
    }
    public function addad(){
        $ad = collect(Ads::first())->keys();
        return view('pages.addad',['ad'=>$ad]);
    }
    public function insertAd(Request $request){
    
        $banner="";
        $file=$request->file('banner_file');
        if($file!=""){
            $destinationPath = "assets/img/ads/";
            $banner=$file->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$file,$banner);
        }
        $insert = new Ads;
        $insert->fill($request->all());
        $insert['banner']=$banner;
        $insert->save();
        $featuredads=Ads::select('*')->get();
        return view('pages.featuredads',['featuredads'=>$featuredads]);
    }
    public function updateAd(Request $request){
        $banner=$request['banner_hash'];
        $file=$request->file('banner_file');
        if($file!=""){
            $destinationPath = "assets/img/ads/";
            if($file!="")
                Storage::disk('public')->delete($destinationPath.$banner);
            $banner=$file->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$file,$banner);
        }
        $ads = Ads::findOrFail($request['id']);
        $input = $request->all();
        //print_r($input); exit();
        $input['banner']=$banner;
        $ads->fill($input)->save();
        $featuredads=Ads::select('*')->get();
        return view('pages.featuredads',['featuredads'=>$featuredads]);
    }



    //Order Management
    public function orders(Request $request){
        $orders = Order::join('users','order.user_id', '=', 'users.id')->join('vendors','order.vendor_id', '=', 'vendors.id')->select('order.id','order.order_no','order.order_status','order.total_order','users.first_name','users.last_name','vendors.shopName');
        if($request['search']){
            $orders=$orders->where('order_no','=',$request['search']);
        }
        $orders=$orders->get();
        return view('pages.orders',['orders'=>$orders]);
    }
    public function orderDetails($id){
        $orderDetails = Order::where('id','=',$id)->select('order.*')->get()->toarray();
        $products = order_Item::where('order_id','=',$orderDetails[0]['id'])->join('products','order_item.product_id','=','products.id')->select('*')->get()->toarray();
        //$products=Product::where('id','=',$user[0]['id'])->select('*')->get()->toarray();
        return view('pages.orderdetails',['orderDetails'=>$orderDetails,'products'=>$products]);
    }
    public function updateOrder(Request $request){
        //echo $request['id'];
        $order  = Order::findOrFail($request['id']);
        $input = $request->all();
        $order->fill($input)->save();
        return redirect()->route('orders');
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
    public function editCategory($id){
        $category = Categories::where('id','=',$id)->select('*')->get()->toarray();
        $parent_categories = Categories::where('parent_category','=',NULL)->select('id','category_name')->get();
        return view('pages.editcategory',['category'=>$category,'parent_categories'=>$parent_categories]);
    }
    public function insertCategory(Request $request){
    
        $icon="";
        $file=$request->file('icon_file');
        if($file!=""){
            $destinationPath = "assets/img/category_icons/";
            $icon=$file->hashName();
            Storage::disk('public')->putFileAs($destinationPath,$file,$icon);
        }
        $insert = new Categories;
        $insert->fill($request->all());
        $insert['icon']=$icon;
        $insert->save();
        $allCategories=Categories::where('parent_category','=',NULL)->get();
        return view('pages.allcategories',['allcategories'=>$allCategories]);
    }
    public function updateCategory(Request $request){

        $icon=$request['icon_hash'];
        $file=$request->file('icon_file');
        if($file!=""){
        $destinationPath = "assets/img/category_icons";
        $icon=$file->hashName();
        Storage::disk('public')->delete($destinationPath.$request['icon_hash']);
        Storage::disk('public')->putFileAs($destinationPath,$file,$icon);
        }
        $category  = Categories::findOrFail($request['id']);
        $input = $request->all();
        $category->fill($input);
        $category['icon']=$icon;
        $category->save();

        return Redirect::to('/categories/'.$request['parent_category']);
    }
}
