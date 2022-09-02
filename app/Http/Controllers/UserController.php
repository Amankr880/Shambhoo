<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $file = $request->file('image');
        $destinationPath = "public/user_img";
        $pic = $file->hashName();
        //$filename = 'https://localhost:8000/public/storage/user_img/'. $file->hashName();
        $filename = 'https://shambhoo.herokuapp.com/storage/user_img/'. $file->hashname();

        Storage::putFileAs($destinationPath, $file, $pic);
        $users->image = $filename;
        // $pic = $request->image->store('public/user_img');
        // $users->image = $request->image->hashName();
        $users->Longitude = $request->input('Longitude');
        $users->Latitude = $request->input('Latitude');
        $users->city = $request->input('city');
        $users->state = $request->input('state');
        $users->pincode = $request->input('pincode');
        $users->token = $token;
        $result = $users->save();
        // $token = User::where('id',$users->id)->get('token');
        if($result)
        {
            return response()->json(['users'=>$users,
                                'msg'=>'User created successfully'],200);
        } else {
            return response()->json(['users'=>$users,
                                'msg'=>'Something went wrong'],400);
        }
        
    }

    public function featureImageShow()
    {
        $path = [];
        $data = HomeData::select('feature_image')->get();
        $filename=explode(",",$data[0]['feature_image']);
        foreach($filename as $pic)
        {
            $path[] = public_path().'/storage/feature_images/'.$pic;
            // $contents[] = Storage::files('feature_images');
          // $contents[] = \File::files(public_path("storage/app/public/feature_images/".$pic));
        }
    
        return $path;
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
            $singleUser = User::where('id','=',$uid)->get();
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
        //$q = User::where('id',$request->user_id)->get('token');
        if($header) 
        {
            $getMe = User::where('token','=',$header)->get();
            $response = response()->json(['user'=>$getMe],200);
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
        $q = User::where('phone',$request->phone)->get('token');
        if($q = $header) 
        {
            $phone = $phoneNo->input('phone_no');
            $userData = User::where('phone_no','=',$phone)->get();
            $userAddress = $userData->address;
            $newAddr = $request->address;
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }

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
