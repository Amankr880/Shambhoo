<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $product_id = $request->input('product_id');
            $quantity = $request->input('quantity');
            $user_id = $request->input('user_id');
            $active = $request->input('active');
            $price = $request->input('price');
    
            $prod_check = Product::where('id',$product_id)->first();
    
            if($prod_check)
            {
                if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->exists())
                {
                    $response = response()->json(['msg'=> $prod_check->product_name.'Already Added!!'],403);
                } 
                else
                {
                    $cartItem = new Cart();
                    $cartItem->product_id = $product_id;
                    $cartItem->quantity = $quantity;
                    $cartItem->user_id = $user_id;
                    $cartItem->price = $price;
                    $cartItem->active = $active;
                    $cartItem->save();
                    $response = response()->json(['msg'=> $prod_check->product_name.'Added to cart!!'],201);
                }
            }
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        
        return $response;
    }

    public function viewCart(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $cartItems = Cart::where('user_id',$request->id)->get();
            $response = response()->json(['cartItem'=>$cartItem],200);
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function deleteProduct(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $cartItems = Cart::where('user_id',$request->id)->where('product_id',$request->product_id)->delete();
            $response = response()->json(['cartItem'=>$cartItem,'msg'=>'Item deleted'],200);
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }
}
