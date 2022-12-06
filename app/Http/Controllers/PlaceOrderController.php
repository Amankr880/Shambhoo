<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Support\Carbon;

class PlaceOrderController extends Controller
{

    public function placeOrder(Request $request)
    {

        if ($request->hasFile('order_type')) {
            $filenameWithExt = $request->file('order_type')->getClientOriginalName ();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('order_type')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename. '_'. time().'.'.$extension;
            $path = $request->file('order_type')->storeAs('public/assets/img/manual_orders', $fileNameToStore);
            }
            // Else add a dummy image
            else {
            //$fileNameToStore = 'public/assets/img/manual_orders/noimage.jpg';
                return response()->json([
                'status' => false,
                'message' => 'Image not uploaded'
            ],501);
            }

        $current_date = Carbon::now()->format('Y-m-d');
        $data = new Order();
        $data->user_id = $request->user_id;
        $data->vendor_id = $request->vendor_id;
        $data->status = '0';
        $data->order_details = $request->description;
        $data->delivery_address = $request->delivery_address;
        $data->order_date = $current_date;
        $data->order_otp = mt_rand(1000,9999);
        $data->order_type = $fileNameToStore;
        $orderNo = 'SHMBO-'.mt_rand(100000,999999);
        $data->order_no = $orderNo;
        $ordersave=$data->save();


        if ($ordersave) {
            $getvendor = Vendor::find($request->vendor_id);
            $token1 = $getvendor->policy;
            $url1 = "https://fcm.googleapis.com/fcm/send";
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
            $respo = curl_exec($ch1);
                //echo $respo;
            curl_close($ch1);


            return response()->json([
                'status' => true,
                'message' => 'Order Placed Successfully'
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Error in order place'
            ],500);
        }
    }
}
