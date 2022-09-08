<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ReviewsController extends Controller
{
    public function createReview(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $reviews = new Reviews();
            $reviews->product_id = $request->input('product_id');
            $reviews->user_id = $request->input('user_id');
            $reviews->vendor_id = $request->input('vendor_id');
            $reviews->description = $request->input('description');
            $reviews->product_rating = $request->input('product_rating');
            $reviews->is_approved = $request->input('is_approved');
            $reviews->delivery_rating = $request->input('delivery_rating');
            $reviews->vendor_rating = $request->input('vendor_rating');

            try{
                $data= $request->all();
                $validator = $this->validatorForStore($data)->validate();
                if(isset($data['images']))
                {
                    if($request->hasfile('images'))
                    {
                        $img=$request->file('images');
                        $filename = [];
                        foreach ($img as $imgkey ) {
                            $imgkey->store('public/review_images');
                            $imgname[]=$imgkey->hashName();
                            $filename[] ='https://shambhoo-app-pfm6i.ondigitalocean.app/storage/review_images/'.$imgkey->hashName();
                        }
                        // var_dump($filename);exit();
                        $filename=implode(",",$filename);
                        // $filename = serialize($filename);
                        $reviews->images = $filename;
                    }else{
                        $imgname=null;
                    }
            }else{
                $imgname=null;
            }
            }
            catch(Exception $e)
            {
                echo 'Message: ' .$e->getMessage();
            }
            $reviews->save();
            $response = response()->json([$reviews,'msg'=>'Review Added!!'],200);
                
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        
        return $response;
    }

    protected function validatorForStore($data){
        if(isset($data['images'])){
            $rules['images.*'] = 'required|mimes:jpg,jpeg,png,mp4,ogx,oga,ogv,ogg,webm|max:20000';
            $rules['images'] = 'max:5';
        }
        
        $messages = [
            "images.max" => "Max 5 images can be attached.",
        ];

        return Validator::make($data, $rules, $messages);
    }

    public function getReview(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $reviews = Reviews::where('vendor_id',$request->vendor_id)->get();
            if($reviews){
                $response = response()->json(['rewiews'=>$reviews],200);
            }
            else
            {
                $response = response()->json(['msg'=>'No rewiews'],403);
            }
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }
}
