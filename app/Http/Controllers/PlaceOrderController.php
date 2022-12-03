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
            // Upload Image$path = $request->file(‘image’)->storeAs(‘public/image’, $fileNameToStore);
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
        $data->order_date = $current_date;
        $data->order_otp = $request->order_otp;
        $data->order_details = $fileNameToStore;
        $response = $data->save();
        if ($response) {
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
