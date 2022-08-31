<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function addProduct(Request $request)
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
                $response = ['msg'=> $prod_check->product_name.'Already Added!!'];
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
                $response = ['msg'=> $prod_check->product_name.'Added to cart!!'];
            }
        }
        return response()->json($response);
    }

    public function viewCart(Request $request)
    {
        $cartItems = Cart::where('user_id',$request->id)->get();
        return response()->json($cartItems);
    }

    public function deleteProduct(Request $request)
    {
        
    }
}
