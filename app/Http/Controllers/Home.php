<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use app\Mail\AccountNotification;
use Mail;

class Home extends Controller{
    
    public function notFound(){
    	echo 'here';
    }

    public function sendEmail(Request $request){
    	$message = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
    	$event = array('name' => 'M Umair', 'msgBody' => $message, 'subject' => 'Welcome');
    	//print_r($event);exit;
    	//Mail::to('mu.cp15@gmail.com')->send(new \app\Mail\AccountNotification($event));
    	Mail::send('emails.welcome', $event, function($message){
		    $message->to('mu.cp15@gmail.com')->subject('Welcome!');
		});
    }
}
?>