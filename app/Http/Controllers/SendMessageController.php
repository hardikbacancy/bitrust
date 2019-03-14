<?php
namespace App\Http\Controllers;
use App\Mail\MessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMessageController extends Controller
{
    public function sendMessage(Request $request){
       if($request->isMethod('post')){
           $user=$request->all();
           $adminEmail="shashi.sagar@bacancytechnology.com";
           Mail::to($adminEmail)->send(new MessageMail($user));
           return redirect()->back()->with('message','Message sent successfully');
       }
    }
}
