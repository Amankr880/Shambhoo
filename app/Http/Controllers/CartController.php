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
            // $active = $request->input('active');
            // $price = $request->input('price');
    
            $prod_check = Product::where('id',$product_id)->first();
    
            if($prod_check)
            {
                if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->exists())
                {
                    $response = response()->json(['msg'=> $prod_check->product_name.' Already Added!!'],403);
                }else{
                    if(Cart::where([['user_id',$user_id],['vendor_id',$prod_check->vendor_id]])->exists())
                    {
                        $cartItem = new Cart();
                        $cartItem->product_id = $product_id;
                        $cartItem->quantity = $quantity;
                        $cartItem->user_id = $user_id;
                        $cartItem->price = $prod_check->MSRP;
                        $cartItem->vendor_id = $prod_check->vendor_id;
                        $cartItem->save();
                        $response = response()->json(['msg'=> $prod_check->product_name.' Added to cart!!'],201);
                    }
                    elseif(Cart::where([['user_id',$user_id],['vendor_id','!=',$prod_check->vendor_id]])->exists())
                    {
                        $response = response()->json(['msg'=>'Cannot add product from different vendor!!'],400);
                    }
                    else
                    {
                        $cartItem = new Cart();
                        $cartItem->product_id = $product_id;
                        $cartItem->quantity = $quantity;
                        $cartItem->user_id = $user_id;
                        $cartItem->price = $prod_check->MSRP;
                        $cartItem->vendor_id = $prod_check->vendor_id;
                        $cartItem->save();
                        $response = response()->json(['msg'=> $prod_check->product_name.' Added to cart!!'],201);
                    }
                }
            }
            else{
                $response = response()->json(['msg'=>'Product is not there'],403);
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
            $cartItems = Cart::where('user_id',$request->user_id)->get();
            if($cartItems!="[]"){
                $response = response()->json(['cartItem'=>$cartItems],200);
            }
            else{
                $response = response()->json(['msg'=>'Cart is empty!!'],403);
            }
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
            $cartItems = Cart::where('user_id',$request->user_id)->where('product_id',$request->product_id)->delete();
            $response = response()->json(['cartItem'=>$cartItems,'msg'=>'Item deleted'],200);
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function updateProduct(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $cartItems = Cart::where([['user_id',$request->user_id],['product_id',$request->product_id]])->update(['quantity'=>$request->quantity]);
            $response = response()->json(['cartItem'=>$cartItems,'msg'=>'Quantity Updated'],200);
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }
}
