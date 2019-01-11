<?php
namespace App\Http\Controllers;
use App\Models\admin\AdminSetting;
use App\Models\admin\LoanRequest;
use App\Models\admin\UserLoanMgmt;
use App\User;

class NonLoanUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminSettings=AdminSetting::all()->toArray();
        $userId=LoanRequest::select('user_id')->where('request_status','=',1)->get()->toArray();
        $users=User::whereNotIn('id',$userId)->get()->toArray();
        return view('admin.non_loan_users.index',get_defined_vars());
    }
}
