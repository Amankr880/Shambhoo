<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $order = new Order();
        $order->user_id = $request->input('user_id');
        $order->order_no = $request->input('order_no');
        $order->order_date = $request->input('order_date');
        $order->ship_date = $request->input('ship_date');
        $order->required_date = $request->input('required_date');
        $order->sales_tax = $request->input('sales_tax');
        // $order->timestamp = $request->input('timestamp');
        // $order->status = $request->input('status');
        $order->transaction_status = $request->input('transaction_status');
        $order->order_status = $request->input('order_status');
        $order->vendor_id = $request->input('vendor_id');
        $order->total_order = $request->input('total_order');
        $order->discount_applied = $request->input('discount_applied');
        $order->total_discount = $request->input('total_discount');
        $order->delivery_address = $request->input('delivery_address');
        $order->discount_type = $request->input('discount_type');
        $order->order_otp = $request->input('order_otp');
        $order->order_type = $request->input('order_type');
        $order->order_details = $request->input('order_details');
        
        $order->save();
        return response()->json(['order'=>$order,'msg'=>'order created successfully!!']);
    }

    public function getOrderByUserId($user_Id)
    {
        $order = Order::where('user_id','=',$user_Id)->get();  
        $response = !$order->isEmpty() ? ['order'=>$order] : ["error"=> "order Not found",'msg'=>'order Not Found!!']; 
        return response()->json($response);
    }

    public function updateOrderStatus(Request $request)
    {
        $order = Order::where('id','=',$request->id)->update(['order_status'=>$request->order_status]);
        $response = $order ? ['order'=>$order,'msg'=>'order updated successfully!!'] : ["error"=> "order Not found",'msg'=>'order Not Found!!'];
        return response()->json($response);
    }
}
