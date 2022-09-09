<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;
use App\Models\vendor_category;
use App\Models\User;
use Storage;
use Illuminate\Support\Facades\File;

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
            // $product->status = $request->input('status');
            $product->vendor_id = $request->input('vendor_id');
            $product->unit_weight = $request->input('unit_weight');
            $product->unit_stock = $request->input('unit_stock');
            $product->unit_in_order = $request->input('unit_in_order');
            $product->discount = $request->input('discount');
            $product->product_available = $request->input('product_available');
            $product->discount_available = $request->input('discount_available');
            $product->ranking = $request->input('ranking');

            $file = $request->file('picture');
            $destinationPath = "public/product_img";
            $pic = $file->hashName();
            $filename = 'https://shambhoo-app-pfm6i.ondigitalocean.app/storage/product_img/'. $file->hashname();
            Storage::putFileAs($destinationPath, $file, $pic);
            $product->picture = $filename;

            $vendor_category = vendor_category::firstOrCreate(['vendor_id' => $request->input('vendor_id'),
                                                            'category_id' => $request->input('category_id'),
                                                            'parent_category' => $request->input('parent_category')]);

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
        $product = Product::where('status','!=','10')->get();  
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
                                    ['status','!=','10']])->get();  
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
            $product = Product::where([['id','=',$request->product_id],['status','!=','10']])->get();
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

    public function getVendorCategory(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $vendor_id = $request->input('vendor_id');
            $vendor_category = vendor_category::join('categories', 'vendor_category.category_id', '=', 'categories.id')
                    ->where([['vendor_category.vendor_id','=',$vendor_id],['categories.status','!=','10']])
                    ->select('vendor_category.*', 'categories.*')->get(); 
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
            $vendor_category = vendor_category::join('categories', 'vendor_category.parent_category', '=', 'categories.id')
                    ->where([['vendor_category.vendor_id','=',$vendor_id],['categories.status','!=','10']])
                    ->select('vendor_category.*', 'categories.*')->get(); 
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
            if($request->picture){
                $image = $request->picture->store('public/product_img');
                $product->picture = $request->picture->hashName();
            }
            
            //$product->picture = $request->input('picture');
            // $image = $request->icon->store('public/product_icon');
            // $product->icon = $request->icon->hashName();
            // $product['picture'][]=[
            //     $request->input('picture')
            //     ];
            
            $product->save();
            $response = ['product'=>$product,'msg'=>'product Updated successfully!!'];
        } else {
            $response = ["error"=> "product Not found",'msg'=>'product Not Found!!'];
        }
       
        return response()->json(['product'=>$product,'msg'=>'product updated successfully!!']);
    }

    public function deleteProduct($id)
    {
        $product = Product::where('id','=',$id)->update(['status'=>'10']);
        $response = $product ? ['product'=>$product,'msg'=>'product deleted successfully!!'] : ["error"=> "product Not found",'msg'=>'product Not Found!!'];
        return response()->json($response);
    }
}
