<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
    	$rules = [
    		'message' => 'required|min:5|max:255'
    	];
    	$messages = [
    		'message.required' => 'Olvidó ingresar un mensaje.',
    		'message.min' => 'Ingrese al menos 5 caracteres.',
    		'message.max' => 'Ingrese como máximo 255 caracteres.'
    	];

    	$this->validate($request, $rules, $messages);

    	$message = new Message();
    	$message->incident_id = $request->input('incident_id');
    	$message->message = $request->input('message');
    	$message->user_id = auth()->user()->id;
    	$is_sms = $request->input('is_sms');

    	if($is_sms)
    	    $message->is_sms = true;
        else
    	    $message->is_sms = false;

    	$message->save();

        if ($message->is_sms = true)
            $this->sendSms($message->incident->client->cellphone, $message->message_complete);

    	return back()->with('notification', 'Su mensaje se ha enviado con éxito.');
    }

    private function sendSms($telnum, $message)
    {
        $rand = rand();
        $url = 'http://10.10.1.12/default/en_US/sms_info.html';
        $line = '1'; // simcardto use in my case #1
        // $telnum = '0987872441'; // phonenumbertosendsms
        //$smscontent = $message; //yourmessage => mensaje prueba 05-12-2017 14.41
        $username = "admin"; //goipusername
        $password = "admin"; //goippassword
        $fields = array(
            'line' =>urlencode($line),
            'smskey' =>urlencode($rand),
            'action' =>urlencode('sms'),
            'telnum' =>urlencode($telnum),
            'smscontent' =>urlencode($message),
            'send' =>urlencode('send')
        );
        $fields_string = '';
        //url-ifythe data forthe POST
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
            //echo "Key: ".$key." value: ".$value."<br>";
        }
        $fields_string = rtrim($fields_string, '&');
        //open connection
        $ch = curl_init();
        //set theurl, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_PORT, 80);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        //execute post
        $resultado = curl_exec($ch);
        $info = curl_getinfo($ch);
        //closeconnection
        curl_close($ch);
    }
}
