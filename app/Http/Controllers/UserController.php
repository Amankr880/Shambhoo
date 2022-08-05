<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_status' => '',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'DOB' => 'date',
            'address' => '',
            'phone_no' => 'required|numeric',
            'user_type' => '',
            'image' => 'required',
            'location' => 'required',
            'pincode' => 'required'

        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
    
          $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
            ));


            return response()->json(['user'=>$user,
                                'msg'=>'User created successfully',
                                'status'=>'201']);
       
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

    public function update(Request $request)
    {
        $users = User::find($request->input('id'));
        $users->username = $request->input('first_name');
        $users->name = $request->input('last_name');
        $users->birth_date = $request->input('DOB');
        $users->email = $request->input('email');
        $users->address = $request->input('address');
        $users->phone_no = $request->input('phone_no');
        $users->password = Hash::make($request->input('password'));
        // $users->user_type = $request->input('user_type');
        // $users->user_type = $request->input('user_status');
        $users->user_type = $request->input('image');
        $users->user_type = $request->input('location');
        $users->user_type = $request->input('pincode');
        $result = $users->save();
        if($result)
        {
            return response()->json(['users'=>$users,
                                'msg'=>'User updated successfully']);
        } else {
            return response()->json(['users'=>$users,
                                'msg'=>'Something went wrong']);
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
                                'msg'=>'User updated successfully']);
        } else {
            return response()->json(['users'=>$users,
                                'msg'=>'Something went wrong']);
        }
    }

    public function updateUserStatus(Request $request)
    {
        $users = User::find($request->input('id'));
        $users->user_type = $request->input('user_status');
        $result = $users->save();
        if($result)
        {
            return response()->json(['users'=>$users,
                                'msg'=>'User updated successfully']);
        } else {
            return response()->json(['users'=>$users,
                                'msg'=>'Something went wrong']);
        }
    }
}
