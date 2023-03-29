<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;
use Validator;
use Storage;

class UserController extends Controller
{
    // public function create(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'first_name' => 'required',
    //         'last_name' => '',
    //         'user_status' => '',
    //         'email' => 'email|unique:users',
    //         'password' => 'min:5',
    //         'DOB' => 'date',
    //         'address' => 'required',
    //         'phone_no' => 'required|numeric', 
    //         'user_type' => '',
    //         'image' => 'required',
    //         'Longitude' => 'required',
    //         'Latitude' => 'required',
    //         'pincode' => 'required',
    //         'city' => '',
    //         'state' => ''
            

    //     ]);
    
    //     if($validator->fails()){
    //         return response()->json($validator->errors()->toJson(), 400);
    //     }
    //     //   $token = Str::random(60);
    //       $user = User::create(array_merge(
    //         $validator->validated()
    //         // ['password' => bcrypt($request->password)]
    //       ));
    //     //   $user->token = $token;
    //       $user->save();


    //         return response()->json(['user'=>$user,
    //                             'msg'=>'User created successfully'
    //                             ],200);
       
    // }

    public function userCreate(Request $request)
    {
        $token = Str::random(60);

        $users = new User;
        $users->first_name = $request->input('first_name');
        $users->last_name = $request->input('last_name');
        $users->DOB = $request->input('DOB');
        $users->email = $request->input('email');
        $users->address = $request->input('address');
        $users->phone_no = $request->input('phone_no');
        //$users->password = Hash::make($request->input('password'));
        // $users->user_type = $request->input('user_type');
        // $users->user_type = $request->input('user_status');
        if($users->user_type){
        $users->user_type = $request->input('user_type');
        }else{
            $users->user_type=0;
        }
        if($users->user_status){
        $users->user_status = $request->input('user_status');
        }else{
            $users->user_status=0;
        }
        if($request->file('image')!=NULL){
        $file = $request->file('image');
        $destinationPath = "public/assets/img/users";
        $pic = $file->hashName();
        //$filename = 'https://shambhoo-app-pfm6i.ondigitalocean.app/storage/assets/img/users/'. $file->hashname();
        Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
        $users->image = $pic;
        }
        $users->Longitude = $request->input('Longitude');
        $users->Latitude = $request->input('Latitude');
        $users->city = $request->input('city');
        $users->state = $request->input('state');
        $users->pincode = $request->input('pincode');
        $users->token = $token;
        $result = $users->save();
        if($result)
        {
            return response()->json(['users'=>$users,
                                'msg'=>'User created successfully'],200);
        } else {
            return response()->json(['users'=>$users,
                                'msg'=>'Something went wrong'],400);
        }
        
    }

    public function show()
    {
      $users = user::all();
      return response()->json($users);
    }
    
    public function displaySingleuser(Request $id)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->id)->get('token');
        if($q = $header) 
        {
            $uid = $id->input('id');
            $singleUser = User::where('id','=',$uid)->select('*',DB::raw("CONCAT('storage/assets/img/users/',image) AS image"))->get();
            $response = response()->json(['singleUser'=>$singleUser],200);
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function getMe(Request $request)
    {
        $header = $request->bearerToken();
        if($header)
        {
            $getMe = User::where('token','=',$header)->select('*',DB::raw("CONCAT('storage/assets/img/users/',image) AS image"))->first();
            if($getMe['token']==NULL){
                $response = response()->json(['msg'=>'User not found'],404);
            }else{
                $response = response()->json($getMe,200);
            }
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function updateAddress(Request $request)
    {
        $header = $request->bearerToken();
        if($header) 
        {
            $userData = User::where('token','=',$header)
                            ->update([
                                'address' => $request->address,
                                'pincode' => $request->pincode,
                                'city' => $request->city,
                                'state' => $request->state,
                                'Latitude' => $request->Latitude,
                                'Longitude' => $request->Longitude
                            ]);
            $response = response()->json(['msg'=>'Address Updated!'],200);
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function update(Request $request)
    {
        $users = User::find($request->input('id'));
        $users->first_name = $request->input('first_name');
        $users->last_name = $request->input('last_name');
        // $users->DOB = $request->input('DOB');
        // $users->email = $request->input('email');
        // $users->address = $request->input('address');
        // $users->phone_no = $request->input('phone_no');
        //$users->password = Hash::make($request->input('password'));
        // $users->user_type = $request->input('user_type');
        // $users->user_type = $request->input('user_status');

        // if($users->user_type){
        // $users->user_type = $request->input('user_type');
        // }else{
        //     $users->user_type=0;
        // }
        // if($users->user_status){
        // $users->user_status = $request->input('user_status');
        // }else{
        //     $users->user_status=0;
        // }
        // $users->image = $request->input('image');
        // $users->Longitude = $request->input('Longitude');
        // $users->Latitude = $request->input('Latitude');
        // $users->city = $request->input('city');
        // $users->state = $request->input('state');
        // $users->pincode = $request->input('pincode');
        $result = $users->save();
        if($result)
        {
            return response()->json(['users'=>$users,
                                'msg'=>'User updated successfully'],200);
        } else {
            return response()->json(['users'=>$users,
                                'msg'=>'Something went wrong'],400);
        }
        //return response()->json($users);
        
    }

    public function updateUserType(Request $request)
    {
        $users = User::find($request->input('id'));
        $users->user_type = $request->input('user_type');
        $result = $users->save();
        if($result)
        {
            return response()->json(['users'=>$users,
                                'msg'=>'User updated successfully'],200);
        } else {
            return response()->json(['users'=>$users,
                                'msg'=>'Something went wrong'],400);
        }
    }

    public function updateUserStatus(Request $request)
    {
        $users = User::find($request->input('id'));
        $users->user_status = $request->input('user_status');
        $result = $users->save();
        if($result)
        {
            return response()->json(['users'=>$users,
                                'msg'=>'User updated successfully'],200);
        } else {
            return response()->json(['users'=>$users,
                                'msg'=>'Something went wrong'],400);
        }
    }
}