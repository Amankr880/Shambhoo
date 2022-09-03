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
                    $filename[]='https://shambhoo.herokuapp.com/storage/feature_images/'.$imgkey->hashName();
                }
                // $imgname=implode(",",$imgname);
                $filename=implode(",",$filename);
                $img = HomeData::insert(['feature_image'=> $filename]);
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
        //$path = [];
        $data = HomeData::select('feature_image')->first();
        //$filename=explode(",",$data[0]['feature_image']);
        // foreach($filename as $pic)
        // {
        //     $path[] = public_path().'/storage/feature_images/'.$pic;
        //     // $contents[] = Storage::files('feature_images');
        //   // $contents[] = \File::files(public_path("storage/app/public/feature_images/".$pic));
        // }
    
        return $data;
    }

    public function getStore(Request $request)
    {
        $shopDetails = Vendor::where('pincode','=',$request->pincode)->get();  
        $response = !$shopDetails->isEmpty() ? ['shopDetails'=>$shopDetails] : ["error"=> "Shops Not Available",'msg'=>'Shops In this Pincode is Not Available!!']; 
        return response()->json($response);
    }

    public function getFeatureStore(Request $request)
    {
        $shopDetails = Vendor::where('pincode','=',$request->pincode)->orderBy('status','DESC')->get();  
        $response = !$shopDetails->isEmpty() ? ['shopDetails'=>$shopDetails] : ["error"=> "Shops Not Available",'msg'=>'Shops In this Pincode is Not Available!!']; 
        return response()->json($response);
    }
    
}
