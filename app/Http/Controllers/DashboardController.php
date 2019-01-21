<?php
namespace App\Http\Controllers;
use App\Models\admin\AdminSetting;
use App\Models\admin\LoanRequest;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if(\Auth::user()->role!='0') {
            $adminSettings = AdminSetting::all()->toArray();
            $userCount = User::where('role', '=', '0')->count();
            $loanAmount = LoanRequest::where('request_status', '=', 1)->sum('loan_amount');
            $loanAmountDetails = LoanRequest::select('id','user_id','loan_amount','tenuar_period')->where('request_status', '=', 1)->get()->toArray();
            $totalMembershipFees = User::where('role','=',0)->sum('membership_fees');

            $profit=0;
            if(!empty($loanAmountDetails)){
               foreach ($loanAmountDetails as $loanAmountDetail){
                   $loanAm=$loanAmountDetail['loan_amount'];
                   $tenuarPeriod=$loanAmountDetail['tenuar_period'];
                   $originalEmi=floor($loanAm/$tenuarPeriod);
                   $interestEmi=UserLoanMgmt::select('emi_amount')
                       ->where('request_id','=',$loanAmountDetail['id'])->first();
                   $interestEmi=$interestEmi->emi_amount;
                   $emiCount = UserLoanMgmt::where('tenuar_status', '=', 1)->where('request_id', '=', $loanAmountDetail['id'])
                       ->count();
                   $profit=$profit+($interestEmi-$originalEmi)*$emiCount;
               }
            }
        }
        else{
            $profit=0;
            $adminSettings = AdminSetting::all()->toArray();
            $userCount = User::where('role', '=', '0')->count();
            $loanAmount = LoanRequest::where('request_status', '=', 1)->where('user_id', '=', \Auth::user()->id)
                ->sum('loan_amount');
            $paidAmount=DB::table('user_loan_mgmts')
                ->where('user_id','=',\Auth::user()->id)->where('tenuar_status','=',1)->sum('emi_amount');

            $unpaidAmount=DB::table('user_loan_mgmts')
                ->where('user_id','=',\Auth::user()->id)->where('tenuar_status','=',0)->sum('emi_amount');
        }
        return view('admin.dashboard',get_defined_vars());
    }
}
