<?php
namespace App\Http\Controllers;
use App\Models\admin\AdminSetting;
use App\Models\admin\LoanRequest;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
        $adminSettings=AdminSetting::all()->toArray();
        $userCount=User::where('role','=','0')->count();
        $loanAmount=LoanRequest::where('request_status','=',1)->sum('loan_amount');
        return view('admin.dashboard',get_defined_vars());
    }
}
