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
    public function index(Request $request)
    {
        $receiverNumber = $request->number;
        $otp = mt_rand(1000,9999);
        // print_r($request->number." - ".$otp);
        $message = "Your OTP for Verification is " .$otp;
        if(User::where('phone_no','=',$receiverNumber)->exists()){
            try {
                $account_sid = getenv("TWILIO_SID");
                $auth_token = getenv("TWILIO_TOKEN");
                $twilio_number = getenv("TWILIO_FROM");
      
                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number, 
                    'body' => $message]);
                //$token = Str::random(60);
                OtpVerification::updateOrInsert(['phone_no' => $receiverNumber],['otp' => $otp]);
                $response =response()->json(["exists"=> 'ture',"msg"=> 'SMS Sent Successfully.','Number'=>$receiverNumber,'Message'=>$message],200);
            } catch (Exception $e) {
                // dd("Error: ". $e->getMessage());
                $response = response()->json(["error"=> $e->getMessage()],400);
            }
        }else {
            try {
  
                $account_sid = getenv("TWILIO_SID");
                $auth_token = getenv("TWILIO_TOKEN");
                $twilio_number = getenv("TWILIO_FROM");
      
                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number, 
                    'body' => $message]);
                //$token = Str::random(60);
                OtpVerification::updateOrInsert(['phone_no' => $receiverNumber],['otp' => $otp]);
                
                $response =response()->json(["exists"=> 'false',"msg"=> 'SMS Sent Successfully.','Number'=>$receiverNumber,'Message'=>$message],200);
      
            } catch (Exception $e) {
                // dd("Error: ". $e->getMessage());
                $response = response()->json(["error"=> $e->getMessage()],400);
            }
        }
        return $response;
    }

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

    public function smsSend(Request $request)
    {
        $receiverNumber = $request->number;
        $otp = mt_rand(1000,9999);
        //$message = "Your OTP for Verification is " .$otp;
            $DLT_TE_ID = "1207161863947285226";
            //Your authentication key
            $authKey = "7842AsWkEs6OChSw5d5fb1d2";

            //Multiple mobiles numbers separated by comma
            $mobileNumber =$receiverNumber;

            //Sender ID,While using route4 sender id should be 6 characters long.
            $senderId = "KALKII";

            //Your message to send, Add URL encoding here.
            $message = urlencode("Your OTP for Verification is " .$otp);

            //Define route 
            $route = "4";
            //Prepare you post parameters
            $postData = array(
                'authkey' => $authKey,
                'mobiles' => $mobileNumber,
                'message' => $message,
                'sender' => $senderId,
                'route' => $route,
                'DLT_TE_ID' => $DLT_TE_ID
            );

            //API URL
            $url="http://www.dakshinfosoft.com/api/sendhttp.php";

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

            echo $output;
        
    }

}