<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Carbon;

class PlaceOrderController extends Controller
{

    public function placeOrder(Request $request)
    {

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName ();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename. '_'. time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/image', $fileNameToStore);
            }
            // Else add a dummy image
            else {
            $fileNameToStore = 'noimage.jpg';
            }

        $current_date = Carbon::now()->format('Y-m-d');
        $data = new Order();
        $data->user_id = $request->user_id;
        $data->vendor_id = $request->vendor_id;
        $data->status = '0';
        $data->order_details = $request->description;
        $data->order_date = $current_date;
        $data->order_otp = mt_rand(1000,9999);
        $data->order_type = $fileNameToStore;
        
        //for notification
        $getvendor = Vendor::find($request->vendor_id);
        $order->device_token = $getvendor->policy;

        $response = $data->save();


        if ($response) {
            $url1 = "https://fcm.googleapis.com/fcm/send";
            $token1 = $request->device_token;
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
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Error in order place'
            ]);
        }
    }
}
