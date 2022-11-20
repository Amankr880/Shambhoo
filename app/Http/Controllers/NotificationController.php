<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Vendor;
use App\Models\User;

class NotificationController extends Controller
{
    public function show(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $getVendorId = Vendor::where('user_id','=',$request->user_id)->get('id');
            $notification = Notification::where([['vendor_id','=',$getVendorId[0]['id']],['is_read','=',0]])->count();
            if($notification){
                $response = response()->json(['notificationCount'=>$notification],200);
            }
            else
            {
                $response = response()->json(['msg'=>'No Notifications'],403);
            }
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function data(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $getVendorId = Vendor::where('user_id','=',$request->user_id)->get('id');
            $notificationCount = Notification::where([['vendor_id','=',$getVendorId[0]['id']],['is_read','=',0]])->count();
            $notificationData = Notification::select('id','description','created_at')->where('vendor_id', $getVendorId[0]['id'])->where('is_read',0)->get();
            if($notificationCount && $notificationData){
                $response = response()->json(['notificationCount'=>$notificationCount,'notificationData'=>$notificationData],200);
            }
            else
            {
                $response = response()->json(['msg'=>'No Notifications'],403);
            }
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function updateNotification(Request $request)
    {
        $data=$request->all();
        Notification::where('id',$request->id)->update([
            'is_read'=>1
        ]);
        return response()->json(['msg'=>'Sucess'],200);
    }
}
