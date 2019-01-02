<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    public function verifyUser($verification_code)
    {
        $verifyUser = User::where('verification_code', $verification_code)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->email_verified_at;
            if($user!='1') {
                $verifyUser->email_verified_at = 1;
                $verifyUser->save();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('/login')->with('status', $status);
    }
}
