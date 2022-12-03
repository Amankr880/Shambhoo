<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use App\Models\PlanSubscription;
use Illuminate\Support\Carbon;

class SubscriptionController extends Controller
{

    public function getSubscription(Request $request)
    {
        // print_r($request->all());
        $current_date = Carbon::now()->format('Y-m-d');
        $validity = Carbon::now()->addYear();
        $data = new PlanSubscription();
        $data->plan_id = '2';
        $data->vendor_id = $request->vendor_id;
        $data->validity = $validity;
        $data->status = 'success';
        $data->plan_type = $request->plan_type;
        $data->purchase_date = $current_date;
        $response = $data->save();



        if ($response) {
            $data = Vendor::find($request->vendor_id);
            $data->status = '2';
            $response2 = $data->save();
            if ($response2) {
                return response()->json([
                    'status' => true,
                    'message' => 'Subscription Purchased Successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Error while purchasing subscription'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Error while purchasing subscription'
            ]);
        }
    }

}
