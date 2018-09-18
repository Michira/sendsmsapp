<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SendSms;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
    * Controller to display the form for creating SMS
    *
    * @return void
    */
    public function Sms()
    {
        return view('sendsms');
    }

     /**
    * Controller to display the form for creating SMS
    *
    * @return void
    */
    public function sendSms(Request $request)
    {
        $recipient = $request->recipient;
        $message = $request->message;

        $results = $this->mySmsSender($recipient, $message);

        foreach($results as $result) {           

            //Lets log the sms that was sent and the status
            $sendsms = SendSms::Create([
                'message' => $message,
                'status' => $result->status,
                'phone' => $result->number
            ]);
        }

        return redirect('/all-sms')->with('status','SMS have been sent. Check table for status');
       
       
    }


    public function allSms(){

        $sms = SendSms::all();

        return view('allsms')->with('sms',$sms);
    }

    /**
    * Function to send SMS using Africa's talking
    *
    * @return array
    */
    public function mySmsSender($recipient, $message){

        // Be sure to include the file you've just downloaded
        
        require_once('AfricasTalkingGateway.php');

        // Specify your authentication credentials
        $username   = "MichSMS";
        $apikey     = "2d4f22d2b4eccec325f60d5cbcf84b93f2cd81220db814a8345ea18a49dcb121";
        // Specify the numbers that you want to send to in a comma-separated list
        // Please ensure you include the country code (+254 for Kenya in this case)
        $recipients = $recipient;
        // And of course we want our recipients to know what we really do
        $message    = $message;
        // Create a new instance of our awesome gateway class
        $gateway    = new AfricasTalkingGateway($username, $apikey);
        /*************************************************************************************
          NOTE: If connecting to the sandbox:
          1. Use "sandbox" as the username
          2. Use the apiKey generated from your sandbox application
             https://account.africastalking.com/apps/sandbox/settings/key
          3. Add the "sandbox" flag to the constructor
          $gateway  = new AfricasTalkingGateway($username, $apiKey, "sandbox");
        **************************************************************************************/
        // Any gateway error will be captured by our custom Exception class below, 
        // so wrap the call in a try-catch block
        try 
        { 
          // Thats it, hit send and we'll take care of the rest. 
          $results = $gateway->sendMessage($recipients, $message);

          return $results;

          return response()->json(['message' => true, 'details' => $results], 200);
                    
          /*foreach($results as $result) {
            // status is either "Success" or "error message"
            echo " Number: " .$result->number;
            echo " Status: " .$result->status;
            echo " StatusCode: " .$result->statusCode;
            echo " MessageId: " .$result->messageId;
            echo " Cost: "   .$result->cost."\n";
          }*/
        }
        catch ( AfricasTalkingGatewayException $e )
        {
             return response()->json(['message' => false, 'details' => $e->getMessage()], 422);
          //echo "Encountered an error while sending: ".$e->getMessage();
        }
    }
}
