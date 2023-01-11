<?php

namespace App\Http\Controllers;

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
        $data2 = Vendor::find($request->vendor_id);
        if(!empty($data2)){
            $current_date = Carbon::now()->format('Y-m-d');
            $month = $request->month;
            $month = number_format($month);
            $validity = Carbon::now()->addMonth($month);
            dd($validity);
            $data = new PlanSubscription();
            $data->plan_id = '2';
            $data->vendor_id = $request->vendor_id;
            $data->validity = $validity;
            $data->status = 'success';
            $data->plan_type = $request->plan_type; //1-basic, 2-premium
            $data->purchase_date = $current_date;
            $response = $data->save();


            if ($response) {

                $data2->status = '2';
                $response2 = $data2->save();
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
        else{
            return response()->json([
                'status' => false,
                'message' => 'Vendor id is invalid'
            ]);
        }

    }
}
