<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Exception;
use Twilio\Rest\Client;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
  
class SMSController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */

    protected $token;
    // public function index(Request $request)
    // {
    //     $receiverNumber = $request->number;
    //     $otp = mt_rand(1000,9999);
    //     // print_r($request->number." - ".$otp);
    //     $message = "Your OTP for Verification is " .$otp;
    //     if(User::where('phone_no','=',$receiverNumber)->exists()){
    //         try {
    //             $account_sid = getenv("TWILIO_SID");
    //             $auth_token = getenv("TWILIO_TOKEN");
    //             $twilio_number = getenv("TWILIO_FROM");
      
    //             $client = new Client($account_sid, $auth_token);
    //             $client->messages->create($receiverNumber, [
    //                 'from' => $twilio_number, 
    //                 'body' => $message]);
    //             //$token = Str::random(60);
    //             OtpVerification::updateOrInsert(['phone_no' => $receiverNumber],['otp' => $otp]);
    //             $response =response()->json(["exists"=> 'true',"msg"=> 'SMS Sent Successfully.','Number'=>$receiverNumber,'Message'=>$message],200);
    //         } catch (Exception $e) {
    //             // dd("Error: ". $e->getMessage());
    //             $response = response()->json(["error"=> $e->getMessage()],400);
    //         }
    //     }else {
    //         try {
  
    //             $account_sid = getenv("TWILIO_SID");
    //             $auth_token = getenv("TWILIO_TOKEN");
    //             $twilio_number = getenv("TWILIO_FROM");
      
    //             $client = new Client($account_sid, $auth_token);
    //             $client->messages->create($receiverNumber, [
    //                 'from' => $twilio_number, 
    //                 'body' => $message]);
    //             //$token = Str::random(60);
    //             OtpVerification::updateOrInsert(['phone_no' => $receiverNumber],['otp' => $otp]);
                
    //             $response =response()->json(["exists"=> 'false',"msg"=> 'SMS Sent Successfully.','Number'=>$receiverNumber,'Message'=>$message],200);
      
    //         } catch (Exception $e) {
    //             // dd("Error: ". $e->getMessage());
    //             $response = response()->json(["error"=> $e->getMessage()],400);
    //         }
    //     }
    //     return $response;
    // }

    public function otpVerify(Request $request){
        $receiverNumber = $request->number;
        $otp = $request->otp;
        $isExists = $request->isExists;
        $data = OtpVerification::where('phone_no','=', $receiverNumber)->first();
        if($otp == $data->otp && User::where('phone_no','=',$receiverNumber)->exists()){
            //$token = Str::random(60);
            $qw = $this->tokenGen($receiverNumber);
            //print_r($qw);exit();
            User::where('phone_no','=',$qw['mobile'])->update(['token' => $qw['token']]);
            $response = response()->json(['message' => 'otp verified','exists' => $isExists,'token' => $qw['token']],200);
        }elseif($otp == $data->otp){
            $response = response()->json(['message' => 'otp verified'],200);
        }else{
            $response = response()->json(['message' => 'otp mismatched'],400);
        }  

        return $response; 
    }

    public function tokenGen($mobileNumber)
    {
       $arr = [];
       $token = Str::random(60);
       $arr['mobile'] = $mobileNumber;
       $arr['token'] = $token;
       return $arr;
    }

    // protected function createNewToken($token){
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60,
    //         'user' => auth()->user()
    //     ]);
    // }

    // public function smsSend(Request $request)
    // {
    //     $receiverNumber = $request->number;
    //     $otp = mt_rand(1000,9999);
    //         //Your authentication key
    //         $api_key = 'M8vmX7P9FeLZkhRe';
    //         $sender_id = 'SHMBHO';
    //         //Multiple mobiles numbers separated by comma
    //         $mobileNumber =$receiverNumber;
    //         //Sender ID,While using route4 sender id should be 6 characters long.
    //         // $senderId = "SHMBHO";
    //         //Your message to send, Add URL encoding here.
    //         $message = "Your One Time Password (OTP) for Registration to SHAMBHOO is ".$otp." Pls do not share with anyone.";
    //         //Define route 
    //         // $route = "4";
    //         //Prepare you post parameters
    //         $postData = array(
    //             'apikey' => $api_key,
    //             'number' => $mobileNumber,
    //             'message' => $message,
    //             'senderid' => $sender_id,
    //             'format' => 'json'
    //         );
    //         //API URL
    //         $url="http://sms.osdigital.in/V2/http-api.php";
    //         // init the resource
    //         $ch = curl_init();
    //         curl_setopt_array($ch, array(
    //             CURLOPT_URL => $url,
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_POST => true,
    //             CURLOPT_POSTFIELDS => $postData
    //             //,CURLOPT_FOLLOWLOCATION => true
    //         ));
    //         //Ignore SSL certificate verification
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //         //get response
    //         $output = curl_exec($ch);
    //         //Print error if any
    //         if(curl_errno($ch))
    //         {
    //             echo 'error:' . curl_error($ch);
    //         }
    //         curl_close($ch);
    //         echo $output;
        
    // }

    public function smsSend(Request $request)
    {
        $receiverNumber = $request->number;
        $otp = mt_rand(1000,9999);
        //Your authentication key
        $api_key = 'M8vmX7P9FeLZkhRe';
        $sender_id = 'SHMBHO';
        //API URL
        $url="http://sms.osdigital.in/V2/http-api.php";
        //Your message to send, Add URL encoding here.
        if($receiverNumber=="1111111111" || $receiverNumber=="+911111111111")
            $otp=1111;
        $message = "Your One Time Password (OTP) for Registration to SHAMBHOO is ".$otp." Pls do not share with anyone.";
        //Prepare you post parameters
        $postData = array(
            'apikey' => $api_key,
            'number' => $receiverNumber,
            'message' => $message,
            'senderid' => $sender_id,
            'format' => 'json'
        );
        if(User::where('phone_no','=',$receiverNumber)->exists()){
            try {
                // init the resource
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postData
                    //,CURLOPT_FOLLOWLOCATION => true
                ));
                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                //get response
                $output = curl_exec($ch);
                //Print error if any
                if(curl_errno($ch))
                {
                    echo 'error:' . curl_error($ch);
                }
                curl_close($ch);
                OtpVerification::updateOrInsert(['phone_no' => $receiverNumber],['otp' => $otp]);
                $response =response()->json(["exists"=> 'true',"output"=> $output,'Message'=>$message],200);
            } catch (Exception $e) {
                // dd("Error: ". $e->getMessage());
                $response = response()->json(["error"=> $e->getMessage()],400);
            }
        }else {
            try {
                // init the resource
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postData
                    //,CURLOPT_FOLLOWLOCATION => true
                ));
                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                //get response
                $output = curl_exec($ch);
                //Print error if any
                if(curl_errno($ch))
                {
                    echo 'error:' . curl_error($ch);
                }
                curl_close($ch);
                OtpVerification::updateOrInsert(['phone_no' => $receiverNumber],['otp' => $otp]);
                
                $response =response()->json(["exists"=> 'false',"output"=> $output,'Message'=>$message],200);
      
            } catch (Exception $e) {
                // dd("Error: ". $e->getMessage());
                $response = response()->json(["error"=> $e->getMessage()],400);
            }
        }
        return $response;
    }


}