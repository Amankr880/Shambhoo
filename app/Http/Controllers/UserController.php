<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Validator;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_status' => '',
            'email' => 'email|unique:users',
            'password' => 'min:5',
            'DOB' => 'date',
            'address' => 'required',
            'phone_no' => 'required|numeric', 
            'user_type' => '',
            'image' => 'required',
            'Longitude' => 'required',
            'Latitude' => 'required',
            'pincode' => 'required',
            'city' => '',
            'state' => ''
            

        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
          $token = Str::random(60);
          $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
          ));
          $user->remember_token = $token;
          $user->save();


            return response()->json(['user'=>$user,
                                'msg'=>'User created successfully',
                                'token' => $token,
                                ],200);
       
    }

    public function show()
    {
      $users = user::all();
      return response()->json($users);
    }
    
    public function displaySingleuser(Request $id)
    {
        $uid = $id->input('id');
        $singleUser = User::where('id','=',$uid)->get();
        return response()->json($singleUser);
    }

    public function getMe(Request $phoneNo)
    {
        $phone = $phoneNo->input('phone_no');
        $getMe = User::where('phone_no','=',$phone)->get();
        return response()->json($getMe);
    }

    public function updateAddress(Request $request)
    {
        $phone = $phoneNo->input('phone_no');
        $userData = User::where('phone_no','=',$phone)->get();
        $userAddress = $userData->address;
        $newAddr = $request->address;

    }

    public function update(Request $request)
    {
        $users = User::find($request->input('id'));
        $users->first_name = $request->input('first_name');
        $users->last_name = $request->input('last_name');
        $users->DOB = $request->input('DOB');
        $users->email = $request->input('email');
        $users->address = $request->input('address');
        $users->phone_no = $request->input('phone_no');
        //$users->password = Hash::make($request->input('password'));
        // $users->user_type = $request->input('user_type');
        // $users->user_type = $request->input('user_status');
        $users->image = $request->input('image');
        $users->Longitude = $request->input('Longitude');
        $users->Latitude = $request->input('Latitude');
        $users->city = $request->input('city');
        $users->state = $request->input('state');
        $users->pincode = $request->input('pincode');
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
