<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
    
            $prod_check = Product::where('id',$product_id)->first();
            
            $cartLastItem = Cart::where('user_id',$user_id)->join('products','products.id','=','carts.product_id')->latest('carts.id')->first();
            $product = Product::where('id',$product_id)->select('*')->get();
            if($cartLastItem != ""){
                if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->count()==0){
                    if($cartLastItem['vendor_id']==$product[0]['vendor_id']){
                        if($product[0]['product_available']=="1"){
                            $cartItem = new Cart();
                            $cartItem->product_id = $product_id;
                            $cartItem->quantity = $quantity;
                            $cartItem->user_id = $user_id;
                            $cartItem->save();
                            $response = response()->json(['msg'=> $prod_check->product_name.' Added to cart!!'],201);
                        }else{
                            $response = response()->json(['msg'=>'Product out of stock!!'],400);
                        }
                    }else{
                        $response = response()->json(['msg'=>'Cannot add product from different vendor!!'],400);
                    }
                }else{
                    $response = response()->json(['msg'=> $prod_check->product_name.' Already Added!!'],403);
                }
            }else{
                if($product[0]['product_available']=="1"){
                    $cartItem = new Cart();
                    $cartItem->product_id = $product_id;
                    $cartItem->quantity = $quantity;
                    $cartItem->user_id = $user_id;
                    $cartItem->save();
                    $response = response()->json(['msg'=> $prod_check->product_name.' Added to cart!!'],201);
                }else{
                    $response = response()->json(['msg'=>'Product out of stock!!'],400);
                }
            }

            // if($prod_check)
            // {
            //     if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->exists())
            //     {
            //         $response = response()->json(['msg'=> $prod_check->product_name.' Already Added!!'],403);
            //     }else{
            //         if($quantity<$prod_check['unit_stock']){
            //             if(Cart::where([['user_id',$user_id],['vendor_id',$prod_check->vendor_id]])->exists())
            //             {
            //                 $cartItem = new Cart();
            //                 $cartItem->product_id = $product_id;
            //                 $cartItem->quantity = $quantity;
            //                 $cartItem->user_id = $user_id;
            //                 $cartItem->price = $prod_check->MSRP;
            //                 $cartItem->vendor_id = $prod_check->vendor_id;
            //                 $cartItem->save();
            //                 $response = response()->json(['msg'=> $prod_check->product_name.' Added to cart!!'],201);
            //             }
            //             elseif(Cart::where([['user_id',$user_id],['vendor_id','!=',$prod_check->vendor_id]])->exists())
            //             {
            //                 $response = response()->json(['msg'=>'Cannot add product from different vendor!!'],400);
            //             }
            //             else
            //             {
            //                 $cartItem = new Cart();
            //                 $cartItem->product_id = $product_id;
            //                 $cartItem->quantity = $quantity;
            //                 $cartItem->user_id = $user_id;
            //                 $cartItem->price = $prod_check->MSRP;
            //                 $cartItem->vendor_id = $prod_check->vendor_id;
            //                 $cartItem->save();
            //                 $response = response()->json(['msg'=> $prod_check->product_name.' Added to cart!!'],201);
            //             }
            //         }else{
            //             $response = response()->json(['msg'=>'Product out of stock!!'],400);
            //         }
            //     }
            // }
            // else{
            //     $response = response()->json(['msg'=>'Product is not there'],403);
            // }
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
            $cartItems = Cart::where([['carts.user_id',$request->user_id]])
                        ->join('products','products.id','=','carts.product_id')
                        ->join('vendors','vendors.id','=','products.vendor_id')
                        ->select('products.product_name','vendors.shopName','vendors.minimum_order','vendors.delivery_slot','products.MSRP',DB::raw("CONCAT('storage/assets/img/product_img/',products.picture) AS picture"),'carts.quantity','products.unit_stock','products.id')->get();

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
