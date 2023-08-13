<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Cart;
use App\Models\vendor_category;
use App\Models\User;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $product = new Product();
            $product->SKU = $request->input('SKU');
            $product->product_name = $request->input('product_name');
            $product->product_desc = $request->input('product_desc');
            $product->attributes = $request->input('attributes');
            $product->category_id = $request->input('category_id');
            $product->unit_price = $request->input('unit_price');
            $product->MSRP = $request->input('MSRP');
            $product->status = 1;
            $product->vendor_id = $request->input('vendor_id');
            $product->unit_weight = $request->input('unit_weight');
            $product->unit_stock = $request->input('unit_stock');
            $product->unit_in_order = $request->input('unit_in_order');
            $product->discount = $request->input('discount');
            $product->product_available = $request->input('product_available');
            $product->discount_available = $request->input('discount_available');
            $product->ranking = $request->input('ranking');

            $picture = [];
            if($request->file('picture1')){
                $file = $request->file('picture1');
                $destinationPath = "assets/img/product_img/";
                $pic = $file->hashName();
                Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
                $picture[0] = $pic;
            }else{
                $picture[0] = "NULL";
            }

            if($request->file('picture2')){
                $file = $request->file('picture2');
                $destinationPath = "assets/img/product_img/";
                $pic = $file->hashName();
                Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
                $picture[1] = $pic;
            }else{
                $picture[1] = "NULL";
            }

            if($request->file('picture3')){
                $file = $request->file('picture3');
                $destinationPath = "assets/img/product_img/";
                $pic = $file->hashName();
                Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
                $picture[2] = $pic;
            }else{
                $picture[2] = "NULL";
            }

            if($request->file('picture4')){
                $file = $request->file('picture4');
                $destinationPath = "assets/img/product_img/";
                $pic = $file->hashName();
                Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
                $picture[3] = $pic;
            }else{
                $picture[3] = "NULL";
            }
            $product->picture = join(",",$picture);
            //$vendor_category = vendor_category::firstOrCreate(['vendor_id' => $request->input('vendor_id'),
              //                                              'category_id' => $request->input('category_id'),
                //                                            'parent_category' => $request->input('parent_category')]);
            if(vendor_category::where([['vendor_id','=',$request->input('vendor_id')],['category_id','=',$request->input('category_id')]])->first()){

            }else{
            vendor_category::insert(['vendor_id' => $request->input('vendor_id'),'category_id' => $request->input('category_id'),'parent_category' => $request->input('parent_category')]);
            }
            //$vendor_category->save();

            $product->save();
            $response = response()->json(['product'=>$product,'msg'=>'product created successfully!!'],200);
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function getAllProducts()
    {
        //if(Categories::where('status' => '10'))

        $product = Product::where([['product_available','!=','0'],['status','!=',0]])->select('*')->get();  
        $count = 0;
            foreach ($product as $key) {
                $inc_picture = explode (",", $key["picture"]);
                $product[$count]["picture0"] = "storage/assets/img/product_img/".$inc_picture[0];
                $product[$count]["picture1"] = "storage/assets/img/product_img/".$inc_picture[1];
                $product[$count]["picture2"] = "storage/assets/img/product_img/".$inc_picture[2];
                $product[$count]["picture3"] = "storage/assets/img/product_img/".$inc_picture[3];
                $count+=1;
            }
        return response()->json($product);
    }

    public function getProductByCategoryId(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $product = Product::where([['category_id','=',$request->input('category_id')],
                                    ['vendor_id','=',$request->input('vendor_id')],
                                    ['product_available','!=','0'],['status','!=',0]])->select('*',DB::raw("CONCAT('storage/assets/img/product_img/',picture) AS picture"))->get();

            $inc_picture = explode (",", $key["picture"]);
            $product[0]["picture0"] = "storage/assets/img/product_img/".$inc_picture[0];
            $product[0]["picture1"] = "storage/assets/img/product_img/".$inc_picture[1];
            $product[0]["picture2"] = "storage/assets/img/product_img/".$inc_picture[2];
            $product[0]["picture3"] = "storage/assets/img/product_img/".$inc_picture[3];
                            
            $cart = Cart::where('user_id',$request->user_id)->get();
            foreach($product as $product_item){
                foreach($cart as $cart_item){
                    if($product_item['id']==$cart_item['product_id']){
                        $product_item['quantity']=$cart_item['quantity'];
                        break;
                    }else{
                        $product_item['quantity']=0;
                    }
                }	
            }
            if($product)
            {
                $response = response()->json($product,200);
            }
            else{
                $response = response()->json(['msg'=>'product Not Found!!'],404);
            } 
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function getSingleProduct(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $product = Product::where([['id','=',$request->product_id],['status','!=',0]])->select('*',DB::raw("CONCAT('storage/assets/img/product_img/',picture) AS picture"))->get();
            if($product)
            {
                $inc_picture = explode (",", $key["picture"]);
                $product[0]["picture0"] = "storage/assets/img/product_img/".$inc_picture[0];
                $product[0]["picture1"] = "storage/assets/img/product_img/".$inc_picture[1];
                $product[0]["picture2"] = "storage/assets/img/product_img/".$inc_picture[2];
                $product[0]["picture3"] = "storage/assets/img/product_img/".$inc_picture[3];
                $response = response()->json($product,200);
            }
            else{
                $response = response()->json(['msg'=>'product Not Found!!'],404);
            } 
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function getVendorCategory(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $vendor_id = $request->input('vendor_id');
            $vendor_category = vendor_category::join('categories', 'vendor_category.category_id', '=', 'categories.id')
                    ->where([['vendor_category.vendor_id','=',$vendor_id],['categories.status','!=','10']])
                    ->select('vendor_category.*', 'categories.*',DB::raw("CONCAT('storage/assets/img/category_icons/',categories.icon) AS icon"))->get(); 
            $response = response()->json(['vendor_category'=>$vendor_category],200);
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function getVendorParentCategory(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $vendor_id = $request->input('vendor_id');

            // $cats_ids=vendor_category::where([['vendor_category.vendor_id','=',$vendor_id],['categories.status','!=','10']])->get();

            // $
            // foreach($cat_ids as $category){
            //     if($category['parent_category']==NULL || $category['parent_category']>0){

            //     }else{

            //     }
            // }

            $vendor_category = vendor_category::join('categories', 'vendor_category.category_id', '=', 'categories.id')
                    -> where([['vendor_category.vendor_id','=',$vendor_id],['categories.status','!=','10']])->distinct()
                    ->select('vendor_category.*', 'categories.*',DB::raw("CONCAT('storage/assets/img/category_icons/',categories.icon) AS icon"))->get();

                    $vendor_parent="";
            for ($i=0;$i<count($vendor_category);$i++) {
                if($vendor_category[$i]['parent_category']==NULL || $vendor_category[$i]['parent_category']==0){
                    
                }else{
                    $vendor_parent=Categories::where('id','=',$vendor_category[$i]['parent_category'])->select('categories.*')->get();
                    $vendor_category[$i]['id']=$vendor_parent[0]['id'];
                    $vendor_category[$i]['category_name']=$vendor_parent[0]['category_name'];
                    $vendor_category[$i]['description']=$vendor_parent[0]['description'];
                    $vendor_category[$i]['icon']="storage/assets/img/category_icons/".$vendor_parent[0]['icon'];
                }
            }
            $response = response()->json(['vendor_category'=>$vendor_category],200);
            
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    // public function getVendorProduct(Request $request)
    // {
    //     $vendor_id = $request->input('vendor_id');
    //     $category_id = $request->input('category_id');
    //     $vendor_category = vendor_category::where('vendor_id','=',$vendor_id)->get();
    //     $product = Product::where([['vendor_id','=',$vendor_id],['status','!=','10']])->get(); 
    //     // $product2 = Product::join('categories', 'products.category_id', '=', 'categories.id')
    //     //             ->where([['products.vendor_id','=',$vendor_id],['products.status','!=','10']])
    //     //             ->select('products.*', 'categories.*')->get(); 
    //     $product2 = Categories::join('products', 'categories.id', '=', 'products.category_id')
    //                 ->where([['products.vendor_id','=',$vendor_id],['products.category_id','=',$category_id],['products.status','!=','10']])
    //                 ->select('products.*')->get(); 
    //      echo ($product2);exit();
    //     $index = 0;
    //     if($product){
    //         foreach($product as $cat_id){
    //             $cat_id = $cat_id->category_id;
    //             $category[] = Categories::where([['id','=',$cat_id],['status','!=','10']])->get();
    //         }
    //     }
    //     else{
    //         $response = response()->json(['msg'=>'vendor has no product!!'],404);
    //     }
    //     if($product && $category)
    //     {
    //         $response = response()->json(['product' => $product,'category'=>$category],200);
    //     }
    //     else{
    //         $response = response()->json(['msg'=>'vendor has no product!!'],404);
    //     }
    //     return $response;
    // }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if($product){
            $product->SKU = $request->input('SKU');
            $product->product_name = $request->input('product_name');
            $product->product_desc = $request->input('product_desc');
            $product->attributes = $request->input('attributes');
            $product->category_id = $request->input('category_id');
            $product->unit_price = $request->input('unit_price');
            $product->MSRP = $request->input('MSRP');
            // $product->status = $request->input('status');
            $product->vendor_id = $request->input('vendor_id');
            $product->unit_weight = $request->input('unit_weight');
            $product->unit_stock = $request->input('unit_stock');
            $product->unit_in_order = $request->input('unit_in_order');
            $product->discount = $request->input('discount');
            $product->product_available = $request->input('product_available');
            $product->discount_available = $request->input('discount_available');
            $product->ranking = $request->input('ranking');
            // if($request->picture){
            //     $file = $request->file('picture');
            //     $destinationPath = "assets/img/product_img/";
            //     $pic = $file->hashName();
            //     Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
            //     $product->picture = $pic;
            // }

            $picture = [];
            $inc_picture = explode (",", $product->picture); 
            if($request->file('picture1') != $inc_picture[0]){
                if($request->file('picture1')!=NULL){
                    $file = $request->file('picture1');
                    $destinationPath = "assets/img/product_img/";
                    if($inc_picture[0]!="NULL"){
                        File::delete($destinationPath.$inc_picture[0]);
                    }
                    $pic = $file->hashName();
                    Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
                    $picture[0] = $pic;
                }else{
                    $picture[0] = "NULL";
                }
            }else{
                $picture[0] = $inc_picture[0];
            }
            if($request->file('picture2') != $inc_picture[1]){
                if($request->file('picture2')!=NULL){
                    $file = $request->file('picture2');
                    if($inc_picture[1]!="NULL"){
                        File::delete($destinationPath.$inc_picture[1]);
                    }
                    $destinationPath = "assets/img/product_img/";
                    $pic = $file->hashName();
                    Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
                    $picture[1] = $pic;
                }else{
                    $picture[1] = "NULL";
                }
            }else{
                $picture[1] = $inc_picture[1];
            }
            if($request->file('picture3') != $inc_picture[2]){
                if($request->file('picture3')!=NULL){
                    $file = $request->file('picture3');
                    if($inc_picture[2]!="NULL"){
                        File::delete($destinationPath.$inc_picture[2]);
                    }
                    $destinationPath = "assets/img/product_img/";
                    $pic = $file->hashName();
                    Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
                    $picture[2] = $pic;
                }else{
                    $picture[2] = "NULL";
                }
            }else{
                $picture[2] = $inc_picture[2];
            }
            if($request->file('picture4') != $inc_picture[3]){
                if($request->file('picture4')!=NULL){
                    $file = $request->file('picture4');
                    if($inc_picture[3]!="NULL"){
                        File::delete($destinationPath.$inc_picture[3]);
                    }
                    $destinationPath = "assets/img/product_img/";
                    $pic = $file->hashName();
                    Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
                    $picture[3] = $pic;
                }else{
                    $picture[3] = "NULL";
                }
            }else{
                $picture[3] = $inc_picture[3];
            }
            //$product->picture = $request->input('picture');
            // $image = $request->icon->store('public/product_icon');
            // $product->icon = $request->icon->hashName();
            // $product['picture'][]=[
            //     $request->input('picture')
            //     ];
            $product->picture = join(",",$picture);
            
            $product->save();
            $response = ['product'=>$product,'msg'=>'product Updated successfully!!'];
        } else {
            $response = ["error"=> "product Not found",'msg'=>'product Not Found!!'];
        }
       
        return response()->json(['product'=>$product,'msg'=>'product updated successfully!!']);
    }

    public function deleteProduct($id)
    {
        $product = Product::where('id','=',$id)->update(['status'=>0]);
        $inc_picture = explode (",", $product->picture); 
        if($inc_picture[0]!="NULL"){
            File::delete("assets/img/product_img/".$inc_picture[0]);
        }
        if($inc_picture[1]!="NULL"){
            File::delete("assets/img/product_img/".$inc_picture[1]);
        }
        if($inc_picture[2]!="NULL"){
            File::delete("assets/img/product_img/".$inc_picture[2]);
        }
        if($inc_picture[3]!="NULL"){
            File::delete("assets/img/product_img/".$inc_picture[3]);
        }
        $response = $product ? ['product'=>$product,'msg'=>'product deleted successfully!!'] : ["error"=> "product Not found",'msg'=>'product Not Found!!'];
        return response()->json($response);
    }
}
