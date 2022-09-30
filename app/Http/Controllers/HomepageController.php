<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeData;
use App\Models\Ads;
use App\Models\Categories;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Storage;
use App\Models\Vendor;
use Illuminate\Support\Facades\File;

class HomepageController extends Controller
{
    public function featureImageUpload(Request $request)
    {
        
        $data= $request->all();
        //$validator = $this->validatorForStore($data)->validate();
        // var_dump($validator);exit();

        if(isset($data['image']))
        {
            if($request->hasfile('image'))
            {
                $img=$request->file('image');
                
                
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
        $data = Ads::where('status','=',1)->select('banner','url')->orderBy('id', 'desc')->limit(3)->get();
        echo $data;exit();
        // $arr = [];
        // foreach($data as $img) {
        //     array_push($arr,$img['banner']);
        //     array_push($arr,$img['url']);
        // }
        // // $q['banner'] = $arr;
        // $q['url'] = $arr;
        if($data){
            $response = response()->json($data,200);
        }
        else {
            $response = response()->json(['msg' => 'image not found'],400);
        }
        return $response;
    }

    public function getStore(Request $request)
    {
        $shopDetails = Vendor::where([['pincode','=',$request->pincode],['status','!=',0],['visibility','=',1]])->get();  
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
        $shopDetails = Vendor::where([['pincode','=',$request->pincode],['status','=',3],['visibility','=',1]])->inRandomOrder()->get(); 
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

    public function getVendorByCategoryId(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $vendors=Product::where([['products.category_id','=',$request->id],['vendors.pincode','=',$request->pincode],
                                    ['status','!=',0],['visibility','=',1]])
                                    ->distinct()->join('vendors','products.vendor_id','=','vendors.id')
                                    ->select('vendors.shopName','vendors.id','vendors.logo_image')->get();
                if($vendors){
                    $response = response()->json($vendors,200);
                }
                else{
                    $response = response()->json(['msg'=>'vendor not found at this pincode'],403);
                }               
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }
    
}
