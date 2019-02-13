<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\EmiRemainderMail;
use App\Models\admin\AdminSetting;
use App\Models\admin\LoanRequest;
use App\Models\admin\Membership;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class EmiPendingEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function emiPendingEmail(Request $request)
    {
        $email=$request->email;
        $today_date = date('Y-m-d');
        $userLoanMgmt = UserLoanMgmt::select('user_loan_mgmts.*','users.name')->join('users','user_loan_mgmts.user_id','=','users.id')->where('request_id', $request->requestId)->where('tenuar_status','=',0)->whereDate('tenuar_date', '<', $today_date)->get();
        Mail::to($email)->send(new EmiRemainderMail($userLoanMgmt));
        return json_encode($userLoanMgmt);

    }
}
