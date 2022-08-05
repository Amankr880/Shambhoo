<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function createProduct(Request $request)
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
        $image = $request->picture->store('public/product_img');
        $product->picture = $request->picture->hashName();
        //$product->picture = $request->input('picture');
        // $image = $request->icon->store('public/product_icon');
        // $product->icon = $request->icon->hashName();
        // $product['picture'][]=[
        //     $request->input('picture')
        //     ];
        
        $product->save();
        return response()->json(['product'=>$product,'msg'=>'product created successfully!!']);
    }

    public function getAllProducts()
    {
        //if(Categories::where('status' => '10'))
        $product = Product::where('status','!=','10')->get();  
        return response()->json($product);
    }

    public function getProductByCategoryId($cate_Id)
    {
        $product = Product::where([['category_id','=',$cate_Id],['status','!=','10']])->get();  
        $response = !$product->isEmpty() ? ['product'=>$product] : ["error"=> "product Not found",'msg'=>'product Not Found!!']; 
        return response()->json($response);
    }

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
