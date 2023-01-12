<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\User;
use Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function createVendor(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $vendor = new Vendor();
            $vendor->shopName = $request->input('shopName');
            $vendor->user_id = $request->input('user_id');
            $vendor->address = $request->input('address');
            $vendor->Longitude = $request->input('Longitude');
            $vendor->Latitude = $request->input('Latitude');
            $vendor->city = $request->input('city');
            $vendor->state = $request->input('state');
            $vendor->pincode = $request->input('pincode');
            $vendor->phone_no = $request->input('phone_no');
            $vendor->email_id = $request->input('email_id');
            $vendor->id_proof_type = $request->input('id_proof_type');
            $vendor->id_proof_no = $request->input('id_proof_no');
            $vendor->pancard_no = $request->input('pancard_no');
            $vendor->gst_no = $request->input('gst_no');
            $vendor->business_doc_type = $request->input('business_doc_type');
            $vendor->business_doc_no = $request->input('business_doc_no');
            $vendor->about = $request->input('about');
            $vendor->delivery_slot = $request->input('delivery_slot');
            $vendor->minimum_order = $request->input('minimum_order');
            // $vendor->status = $request->input('status');
            $vendor->visibility = 1;

            if($vendor->status){
            $vendor->status = $request->input('status');
            }else{
                $vendor->status=0;
            }
            
            $vendor->policy = $request->input('policy');
        
            $file = $request->file('id_proof_photo');
            $destinationPath = "assets/img/id_proof/";
            $pic = $file->hashName();
            // $filename = 'https://shambhoo-app-pfm6i.ondigitalocean.app/storage/id_proof_photo/'. $file->hashname();
            Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
            $vendor->id_proof_photo = $pic;


            $file = $request->file('pancard_photo');
            if($file!=NULL){
            $destinationPath = "assets/img/pancard/";
            $pic = $file->hashName();
            // $filename = 'https://shambhoo-app-pfm6i.ondigitalocean.app/storage/pancard_photo/'. $file->hashname();
            Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
            $vendor->pancard_photo = $pic;
            }else{
                $vendor->pancard_photo = NULL;
            }


            $file = $request->file('business_doc_photo');
            if($file!=NULL){
            $destinationPath = "assets/img/business_doc/";
            $pic = $file->hashName();
            // $filename = 'https://shambhoo-app-pfm6i.ondigitalocean.app/storage/business_doc_photo/'. $file->hashname();
            Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
            $vendor->business_doc_photo = $pic;
            }else{
                $vendor->business_doc_photo = NULL;
            }
            $file = $request->file('logo_image');
            $destinationPath = "assets/img/logo/";
            $pic = $file->hashName();
            // $filename = 'https://shambhoo-app-pfm6i.ondigitalocean.app/storage/logo_image/'. $file->hashname();
            Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
            $vendor->logo_image = $pic;

            $file = $request->file('header_image');
            $destinationPath = "assets/img/header/";
            $pic = $file->hashName();
            // $filename = 'https://shambhoo-app-pfm6i.ondigitalocean.app/storage/header_image/'. $file->hashname();
            Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
            $vendor->header_image = $pic;

            $file = $request->file('fssai');
            if($file!=NULL){
            $destinationPath = "assets/img/fssai/";
            $pic = $file->hashName();
            // $filename = 'https://shambhoo-app-pfm6i.ondigitalocean.app/storage/header_image/'. $file->hashname();
            Storage::disk('public')->putFileAs($destinationPath, $file, $pic);
            $vendor->fssai = $pic;
            }else{
                $vendor->fssai = NULL;
            }
            // try{
            //     $data= $request->all();
            // $validator = $this->validatorForStore($data)->validate();
            // if(isset($data['gallery']))
            // {
            //     if($request->hasfile('gallery'))
            //     {
            //         $img=$request->file('gallery');
            //         $filename = [];
            //         foreach ($img as $imgkey ) {
            //             $imgkey->store('public/gallery');
            //             $imgname[]=$imgkey->hashName();
            //             $filename[] ='https://shambhoo-app-pfm6i.ondigitalocean.app/storage/gallery/'.$imgkey->hashName();
            //         }
            //         $filename=implode(",",$filename);
            //         $vendor->gallery = $filename;
            //     }else{
            //         $imgname=null;
            //     }
            // }else{
            //     $imgname=null;
            // }
            // }
            // catch(Exception $e)
            // {
            //     echo 'Message: ' .$e->getMessage();
            // }

            $vendor->save();
	$affected = User::where('id',$vendor->user_id)->update(['user_type' => 1]);
    //$affected->save();
            $response = response()->json(['vendor'=>$vendor,'msg'=>'vendor created successfully!!'],200);
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    public function getVendorByUserId($user_Id)
    {
        $vendor = Vendor::where('user_id','=',$user_Id)->select('*',DB::raw("CONCAT('storage/assets/img/logo/',logo_image) AS logo_image,CONCAT('storage/assets/img/header/',header_image) AS header_image,CONCAT('storage/assets/img/gallery/',gallery) AS gallery"))->get(); 
        $response = !$vendor->isEmpty() ? ['vendor'=>$vendor] : ["error"=> "vendor Not found",'msg'=>'vendor Not Found!!']; 

        return response()->json($response);
    }

    public function updateVendor(Request $request, $user_id)
    {
        $vendor = Vendor::where('user_id','=',$user_Id)->get();
        if($vendor){
            $vendor->shopName = $request->input('shopName');
            $vendor->address = $request->input('address');
            $vendor->Longitude = $request->input('Longitude');
            $vendor->Latitude = $request->input('Latitude');
            $vendor->city = $request->input('city');
            $vendor->state = $request->input('state');
            $vendor->pincode = $request->input('pincode');
            $vendor->phone_no = $request->input('phone_no');
            $vendor->email_id = $request->input('email_id');
            $vendor->id_proof_type = $request->input('id_proof_type');
            $vendor->id_proof_no = $request->input('id_proof_no');
            // $vendor->id_proof_photo = $request->input('id_proof_photo');
            $image = $request->id_proof_photo->store('public/id_proof_photo');
            $vendor->id_proof_photo = $request->id_proof_photo->hashName();
            $vendor->pancard_no = $request->input('pancard_no');
            //$vendor->pancard_photo = $request->input('pancard_photo');
            $image = $request->pancard_photo->store('public/pancard_photo');
            $vendor->pancard_photo = $request->pancard_photo->hashName();
            $vendor->gst_no = $request->input('gst_no');
            $vendor->business_doc_type = $request->input('business_doc_type');
            $vendor->business_doc_no = $request->input('business_doc_no');
            $vendor->business_doc_type = $request->input('business_doc_type');
            //$vendor->business_doc_photo = $request->input('business_doc_photo');
            $image = $request->business_doc_photo->store('public/business_doc_photo');
            $vendor->business_doc_photo = $request->business_doc_photo->hashName();
            $vendor->about = $request->input('about');
            // $vendor->logo_image = $request->input('logo_image');
            $image = $request->logo_image->store('public/logo_image');
            $vendor->logo_image = $request->logo_image->hashName();
            // $vendor->header_image = $request->input('header_image');
            $image = $request->header_image->store('public/header_image');
            $vendor->header_image = $request->header_image->hashName();
            // $vendor->gallery = $request->input('gallery');
            $image = $request->gallery->store('public/gallery');
            $vendor->gallery = $request->gallery->hashName();
            $vendor->delivery_slot = $request->input('delivery_slot');
            $vendor->status = $request->input('status');
            //$vendor->visibility = $request->input('visibility');
            $vendor->policy = $request->input('policy');
            $image = $request->picture->store('public/vendor_img');
            $vendor->picture = $request->picture->hashName();
            //$vendor->picture = $request->input('picture');
            // $image = $request->icon->store('public/vendor_icon');
            // $vendor->icon = $request->icon->hashName();
            // $vendor['picture'][]=[
            //     $request->input('picture')
            //     ];
            
            $vendor->save();
            $response = ['vendor'=>$vendor,'msg'=>'vendor Updated successfully!!'];
        } else {
            $response = ["error"=> "vendor Not found",'msg'=>'vendor Not Found!!'];
        }
       
        return response()->json(['vendor'=>$vendor,'msg'=>'vendor updated successfully!!']);
    }

    public function getVendor(Request $request)
    {
        $header = $request->bearerToken();

        //$q = User::where('id',$request->user_id)->get('token');
        if($header) //$q = 
        {


        $vendor = Vendor::where('user_id','=',$request->id)->leftJoin('plan_subscriptions','vendors.id','=','plan_subscriptions.vendor_id')->select('vendors.*','plan_subscriptions.validity',DB::raw("CONCAT('storage/assets/img/logo/',logo_image) AS logo_image,CONCAT('storage/assets/img/header/',header_image) AS header_image"))->get();
        //return $vendor;

        if(count($vendor)==0){
            $response = response()->json(['msg'=>'Vendor not found.'],403);
            return $response;
        }

        
        $product = Product::where([['vendor_id','=',$vendor[0]->id],['status','!=',0]])->leftJoin('categories','products.category_id','=','categories.id')->select('products.*',DB::raw("CONCAT('storage/assets/img/product_img/',picture) AS picture"),'categories.parent_category')->get();

        $device_token = $request->device_token;
        //$data1 = Vendor::find($vendor[0]['id']);
        //dd($data1);
        $vendor[0]->policy = $device_token;
        $vendor[0]->save();

        $data = [
            'vendor'=>$vendor,
            'product'=>$product,
            ]; 
           $response =  response()->json($data);

        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
    }

    // protected function validatorForStore($data){
    //     if(isset($data['gallery'])){
    //         $rules['gallery.*'] = 'required|mimes:jpg,jpeg,png,mp4,ogx,oga,ogv,ogg,webm|max:20000';
    //         $rules['gallery'] = 'max:5';
    //     }
        
    //     $messages = [
    //         "gallery.max" => "Max 5 images can be attached.",
    //     ];

    //     return Validator::make($data, $rules, $messages);
    // }
}
