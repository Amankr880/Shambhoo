<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Exception;
use Twilio\Rest\Client;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
  
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
                // $token = Str::random(60);
                OtpVerification::updateOrInsert(['phone_no' => $receiverNumber],['otp' => $otp]);

                $response = ["exists"=> 'true',"msg"=> 'SMS Sent Successfully.','Number'=>$receiverNumber,'Message'=>$message];
      
            } catch (Exception $e) {
                // dd("Error: ". $e->getMessage());
                $response = ["error"=> $e->getMessage(),'status'=>'403'];
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
                // $token = Str::random(60);
                OtpVerification::updateOrInsert(['phone_no' => $receiverNumber],['otp' => $otp]);
                
                $response = ["exists"=> 'false',"msg"=> 'SMS Sent Successfully.','Number'=>$receiverNumber,'Message'=>$message];
      
            } catch (Exception $e) {
                // dd("Error: ". $e->getMessage());
                $response = ["error"=> $e->getMessage(),'status'=>'403'];
            }
        }
        return response()->json(['message' => $response]);
    }

    public function otpVerify(Request $request){
        $receiverNumber = $request->number;
        $otp = $request->otp;
        $isExists = $request->isExists;
        $data = OtpVerification::where('phone_no','=', $receiverNumber)->first();
        if($otp == $data->otp){
            $response = ['msg'=>'otp verified','exists' => $isExists];
            //Auth::login($user, true);
        }else{
            $response = ['msg'=>'otp mismatched','status'=>'401'];
        }   
        return response()->json(['message' => $response]); 
    }

    // protected function createNewToken($token){
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60,
    //         'user' => auth()->user()
    //     ]);
    // }

}