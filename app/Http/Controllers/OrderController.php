<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Product;
use App\Models\order_Item;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            if(Cart::where('user_id',$request->input('user_id'))->exists())
            {
                $product_id = $request->input('product_id');
                $order = new Order();
                $order->user_id = $request->input('user_id');
                $order->order_date = $request->input('order_date');
                $order->transaction_status = $request->input('transaction_status');
                $order->order_status = $request->input('order_status');
                $prod = Product::where('id',$product_id)->first();
                $order->vendor_id = $prod->vendor_id;
                $order->total_order = $request->input('total_order');
                $order->total_discount = $request->input('total_discount');
                $order->delivery_address = $request->input('delivery_address');
                $order->discount_type = $request->input('discount_type');
                $otp = mt_rand(1000,9999);
                $order->order_otp = $otp;
                $orderNo = 'SHMBO-'.mt_rand(100000,999999);
                $order->order_no = $orderNo;

                //for notification
                //$getvendor = Vendor::find($prod->vendor_id);
                //$order->policy = $getvendor->policy;


                // $order->total_order = $request->input('total_order');
                // $order->order_type = $request->input('order_type');
                // $order->ship_date = $request->input('ship_date');
                // $order->required_date = $request->input('required_date');
                // $order->sales_tax = $request->input('sales_tax');
                // $order->timestamp = $request->input('timestamp');
                // $order->status = $request->input('status');
                // $order->discount_applied = $request->input('discount_applied');
                // $order->discount_type = $request->input('discount_type');
                $order->order_details = $request->input('order_details');
                $order->save();

                $cart_items = Cart::where('user_id',$request->input('user_id'))->get();
                foreach($cart_items as $data){
                    $order_item = new order_Item;
                    $order_item->product_id = $data->product_id;
                    $order_item->quantity = $data->quantity;
                    $order_item->order_id = $order->id;
                    $order_item->save();
                }
                $products = [];
                foreach($cart_items as $res){
                    $products[] = Product::where('id',$res->product_id)->first();
                }
                $delete_cart_items = Cart::where('user_id',$request->input('user_id'))->delete();
                //$notificaton = Notification::insert([
                  //  'description' => "You have a new Order.",
                   // 'vendor_id' => $prod->vendor_id
                //]);
            
            try{
                $getvendor = Vendor::find($prod->vendor_id);
                $token1 = $getvendor->policy;
                $url1 = "https://fcm.googleapis.com/fcm/send";
                //$token1 = $request->device_token;
                $serverKey1 = 'AAAAx5MCry8:APA91bFjVW3GG0vIaReUN1TugWzzgSvQxONQd1nIhzZnEQBNncYXbVBJqU6hRQmzHs_g9CyRzb2qDAfJsdnCM9gsbSKkAbIQwjI1_45y9yXf8lHHub0D8h8gvcgVMbwlwoDNT0unEam7';
                $title1 = 'Order Confimation';
                $body1 = 'Your Order has been placed successfully';
                $notification1 = array('title' =>$title1 , 'text' => $body1, 'sound' => 'default', 'badge' => '1');
                $arrayToSend1 = array('to' => $token1, 'notification' => $notification1,'priority'=>'high');

                $json1 = json_encode($arrayToSend1);
                $headers1 = array();
                $headers1[] = 'Content-Type: application/json';
                $headers1[] = 'Authorization: key='. $serverKey1;
                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_URL, $url1);
                curl_setopt($ch1, CURLOPT_CUSTOMREQUEST,"POST");
                curl_setopt($ch1, CURLOPT_POSTFIELDS, $json1);
                curl_setopt($ch1, CURLOPT_HTTPHEADER,$headers1);
                //Send the request
                curl_exec($ch1);
                    //echo $respo;
                curl_close($ch1);
            }catch(Exception $e){
                echo $e->getMessage();
            }
        $response = response()->json(['order'=>$order,'products'=>$products,'msg'=>'order created successfully!!'],200);

            }
            else{
                $response = response()->json(['msg'=>'Cart Is empty'],403);
            }
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    // public function getOrderByUserId($user_Id)
    // {
    //     $order = Order::where('user_id','=',$user_Id)->get();  
    //     $response = !$order->isEmpty() ? ['order'=>$order] : ["error"=> "order Not found",'msg'=>'order Not Found!!']; 
    //     return response()->json($response);
    // }

    public function getOrderByUserId($user_Id)
    {
            $orderItems = Order::where('order.user_id','=',$user_Id)->orderBy('order.id','DESC')
                        ->leftJoin('order_item','order.id','=','order_item.order_id')
                        ->leftJoin('products','products.id','=','order_item.product_id')
                        ->leftJoin('vendors','vendors.id','=','order.vendor_id')
                        ->select('order.*','order.id','products.product_name','vendors.shopName','vendors.address','order_item.quantity'
                        ,DB::raw("CONCAT('storage/assets/img/product_img/',products.picture) AS picture,CONCAT('storage/assets/img/logo/',vendors.logo_image) AS logo_image, CONCAT('public/assets/img/manual_orders',order.order_type) AS order_type"))
                        ->get()
                        ->groupBy('id');
            if($orderItems!="[]"){
                $response = response()->json(['orderItems'=>$orderItems],200);
            }
            else{
                $response = response()->json(['msg'=>'No orders!!'],403);
            }
        return $response;
    }

    public function updateOrderStatus(Request $request)
    {
        $order = Order::where('id','=',$request->id)->update(['order_status'=>$request->order_status]);
        $response = $order ? ['order'=>$order,'msg'=>'order updated successfully!!'] : ["error"=> "order Not found",'msg'=>'order Not Found!!'];
        return response()->json($response);
    }

    public function updateActiveOrderStatus(Request $request)
    {
        $order = Order::where('id','=',$request->id)->update(['status'=>$request->status]);
        $response = $order ? ['order'=>$order,'msg'=>'Status updated successfully!!'] : ["error"=> "order Not found",'msg'=>'order Not Found!!'];
        return response()->json($response);
    }

    public function pendingOrder(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $getVendorId = Vendor::where('user_id','=',$request->user_id)->get('id');
            $orderItems = Order::where([['order.vendor_id','=',$getVendorId[0]['id']],['order_status',0]])->orderBy('order.id','DESC')
                        ->leftJoin('order_item','order.id','=','order_item.order_id')
                        ->leftJoin('products','products.id','=','order_item.product_id')
                        ->select('order.*','order.id','products.product_name','order_item.quantity'
                        ,DB::raw("CONCAT('storage/assets/img/product_img/',products.picture) AS picture"),DB::raw("CONCAT('storage/assets/img/manual_orders/',order.order_type) AS order_type"))
                        ->get()
                        ->groupBy('id');
            if($orderItems!="[]"){
                $response = response()->json(['orderItems'=>$orderItems],200);
            }
            else{
                $response = response()->json(['msg'=>'No orders!!'],403);
            }
            
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function activeOrder(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $getVendorId = Vendor::where('user_id','=',$request->user_id)->get('id');
            $orderItems = Order::where([['order.vendor_id','=',$getVendorId[0]['id']],['order_status',1]])->orWhere([['order.vendor_id','=',$getVendorId[0]['id']],['order_status',2]])->orderBy('order.id','DESC')
                        ->leftJoin('order_item','order.id','=','order_item.order_id')
                        ->leftJoin('products','products.id','=','order_item.product_id')
                        ->select('order.*','order.id','products.product_name','order_item.quantity'
                        ,DB::raw("CONCAT('storage/assets/img/product_img/',products.picture) AS picture"),DB::raw("CONCAT('storage/assets/img/manual_orders/',order.order_type) AS order_type"))
                        ->get()
                        ->groupBy('id');
            if($orderItems!="[]"){
                $response = response()->json(['orderItems'=>$orderItems],200);
            }
            else{
                $response = response()->json(['msg'=>'No orders!!'],403);
            }
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function historyOrder(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $getVendorId = Vendor::where('user_id','=',$request->user_id)->get('id');
            $orderItems = Order::where([['order.vendor_id','=',$getVendorId[0]['id']],['order_status',3]])->orWhere([['order.vendor_id','=',$getVendorId[0]['id']],['order_status',4]])->orderBy('order.id','DESC')
                        ->leftJoin('order_item','order.id','=','order_item.order_id')
                        ->leftJoin('products','products.id','=','order_item.product_id')
                        ->select('order.*','order.id','products.product_name','order_item.quantity'
                        ,DB::raw("CONCAT('storage/assets/img/product_img/',products.picture) AS picture"),DB::raw("CONCAT('storage/assets/img/manual_orders/',order.order_type) AS order_type"))
                        ->get()
                        ->groupBy('id');
            if($orderItems!="[]"){
                $response = response()->json(['orderItems'=>$orderItems],200);
            }
            else{
                $response = response()->json(['msg'=>'No orders!!'],403);
            }
            
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

public function getAllOrder(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $getVendorId = Vendor::where('user_id','=',$request->user_id)->get('id');
            $orderItems = Order::where('order.vendor_id','=',$getVendorId[0]['id'])->orderBy('order.id','DESC')
                        ->leftJoin('order_item','order.id','=','order_item.order_id')
                        ->leftJoin('products','products.id','=','order_item.product_id')
                        ->select('order.*','order.id','products.product_name','order_item.quantity'
                        ,DB::raw("CONCAT('storage/assets/img/product_img/',products.picture) AS picture"),DB::raw("CONCAT('storage/assets/img/manual_orders/',order.order_type) AS order_type"))
                        ->get()
                        ->groupBy('id');
            if($orderItems!="[]"){
                $response = response()->json(['orderItems'=>$orderItems],200);
            }
            else{
                $response = response()->json(['msg'=>'No orders!!'],403);
            }

        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }
}
