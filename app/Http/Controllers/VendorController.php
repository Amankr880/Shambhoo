<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function createVendor(Request $request)
    {
        $vendor = new Vendor();
        $vendor->shopName = $request->input('shopName');
        $vendor->user_id = $request->input('user_id');
        $vendor->address = $request->input('address');
        //$vendor->location = $request->input('location');    SOlve this
        $ip = $request->ip();
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
        $vendor->visibility = $request->input('visibility');
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
        return response()->json(['vendor'=>$vendor,'msg'=>'vendor created successfully!!']);
    }

    public function getVendorByUserId($user_Id)
    {
        $vendor = Vendor::where('user_id','=',$user_Id)->get();  
        $response = !$vendor->isEmpty() ? ['vendor'=>$vendor] : ["error"=> "vendor Not found",'msg'=>'vendor Not Found!!']; 
        return response()->json($response);
    }

    public function updateVendor(Request $request, $user_id)
    {
        $vendor = Vendor::where('user_id','=',$user_Id)->get();
        if($vendor){
            $vendor->shopName = $request->input('shopName');
            $vendor->address = $request->input('address');
            $vendor->location = $request->input('location');
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
            $vendor->visibility = $request->input('visibility');
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
}
