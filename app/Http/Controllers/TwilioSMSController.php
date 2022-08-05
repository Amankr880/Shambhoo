<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Exception;
use Twilio\Rest\Client;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Auth;
  
class TwilioSMSController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
        $receiverNumber = $request->number;
        $otp = mt_rand(1000,9999);
        print_r($request->number." - ".$otp);
        $message = "Your OTP for Verification is " .$otp;
        if(OtpVerification::where('phone_no','=',$receiverNumber)->exists()){
            $response = ["exists"=> 'true'];
        }else {
            try {
  
                $account_sid = getenv("TWILIO_SID");
                $auth_token = getenv("TWILIO_TOKEN");
                $twilio_number = getenv("TWILIO_FROM");
      
                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number, 
                    'body' => $message]);
    
                OtpVerification::updateOrInsert(['phone_no' => $receiverNumber],['otp' => $otp]);
    
                $response = ["exists"=> 'false',"msg"=> 'SMS Sent Successfully.','Number'=>$receiverNumber,'Message'=>$message];
      
            } catch (Exception $e) {
                // dd("Error: ". $e->getMessage());
                $response = ["error"=> $e->getMessage()];
            }
        }
        return response()->json(['message' => $response]);
    }

    public function otpVerify(Request $request){
        $receiverNumber = $request->number;
        $otp = $request->otp;
        $data = OtpVerification::where('phone_no','=', $receiverNumber)->first();
        if($otp == $data->otp){
            $response = ['msg'=>'otp verified'];
            // Auth::login($user, true);
        }else{
            $response = ['msg'=>'otp mismatched'];
        }   
        return response()->json(['message' => $response]); 
    }
}