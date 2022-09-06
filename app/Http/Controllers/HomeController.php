<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeData;
use Illuminate\Support\Facades\Validator;
use Storage;
use App\Models\Vendor;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function featureImageUpload(Request $request)
    {
        $data= $request->all();
        $validator = $this->validatorForStore($data)->validate();

        if(isset($data['image']))
        {
            if($request->hasfile('image'))
            {
                $img=$request->file('image');
                $filename = [];
                foreach ($img as $imgkey ) {
                    $imgkey->store('public/feature_images');
                    $imgname[]=$imgkey->hashName();
                    $filename[]='https://shambhoo-app-pfm6i.ondigitalocean.app/storage/feature_images/'.$imgkey->hashName();
                }
                foreach($filename as $file) {
                    $q = HomeData::insert(['feature_image'=> $file]);
                }
                // $imgname=implode(",",$imgname);
                // $filename=implode(",",$filename);
                // $img = HomeData::insert(['feature_image'=> $filename]);
            }else{
                $imgname=null;
            }
        }else{
            $imgname=null;
        }
        return response()->json(['image'=>$filename,'msg'=>'photos uploaded successfully!!']);
    }

    protected function validatorForStore($data){
        if(isset($data['image'])){
            $rules['image.*'] = 'required|mimes:jpg,jpeg,png,mp4,ogx,oga,ogv,ogg,webm|max:20000';
            $rules['image'] = 'max:3';
        }
        
        $messages = [
            "image.max" => "Max 3 images can be attached.",
        ];

        return Validator::make($data, $rules, $messages);
    }

    public function featureImageShow()
    {
        $data = HomeData::select('feature_image')->orderBy('id', 'desc')->limit(3)->get();
        $arr = [];
        foreach($data as $img) {
            array_push($arr,$img['feature_image']);
        }
        $q['feature_image'] = $arr;
        if($data){
            $response = response()->json($q,200);
        }
        else {
            $response = response()->json(['msg' => 'image not found'],400);
        }
        return $response;
    }

    public function getStore(Request $request)
    {
        $shopDetails = Vendor::where('pincode','=',$request->pincode)->get();  
        if($shopDetails)
        {
            $response = response()->json($shopDetails,200);
        }
        else{
            $response = response()->json(['msg'=>'Shops In this Pincode is Not Available!!'],404);
        }
        return $response;
    }

    public function getFeatureStore(Request $request)
    {
        $shopDetails = Vendor::where('pincode','=',$request->pincode)->orderBy('status','DESC')->get(); 
        if($shopDetails)
        {
            $response = response()->json($shopDetails,200);
        }
        else{
            $response = response()->json(['msg'=>'Shops In this Pincode is Not Available!!'],404);
        } 
        return $response;
    }

    public function getSingleStore(Request $request)
    {
        $shopDetails = Vendor::where('id','=',$request->id)->first(); 
        if($shopDetails)
        {
            $response = response()->json($shopDetails,200);
        }
        else{
            $response = response()->json(['msg'=>'Shops In this Pincode is Not Available!!'],404);
        } 
        return $response;
    }
    
}
