<?php
//Use this helper file to add unified communication channels

//send emails with our helper function
function sendEmail($emailReceiver, $emailMessage, $emailSubject, $link=null){
	
	Illuminate\Support\Facades\Mail::to($emailReceiver)
		->send(new App\Mail\SchoolMailer($emailMessage,$emailSubject,$link));
}


//extract first name
function extract_firstname($data)
    {
            if (!strpos($data, " ")) {
                return $data;
            }else{
                return substr($data, 0,strpos($data," "));
            }
    }



