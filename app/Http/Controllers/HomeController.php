<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as MyRequest;

class HomeController extends Controller
{
    public function requestfrm(){

        return view('forms.request');
    }

    public function store(Request $request){
        //test to see if a similar suggestion exists
        $req=MyRequest::where('email','=',$request->input('email'))->get()->first();

        
        if ($req !==null) {
            //reject duplicate entries

            return redirect()->back()->with('1',toastr()->error('We have already received your request. kindly allow us some time to act on it before you submit another request.'));
        }
        

         MyRequest::create([
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'phone'=> $request->input('phone'),
            'purpose'=> $request->input('purpose'),
            'description'=> $request->input('description'),
        ]); 

        //send an email
        $emailSubject= "Thank you for contacting us ".extract_firstname($request->input('name')).".";
        $emailMessage="Greetings ".extract_firstname($request->input('name')).", we have received the request you submitted via our online platform and we will act on it appropriately.";
        $receiver = $request->input('email');
        sendEmail($receiver,$emailMessage,$emailSubject);
        
        flash()->success('Request sent successfully.');
        return redirect()->back();
    }
}
