<?php
namespace App\Http\Controllers;
use App\Models\admin\AdminSetting;
use App\Models\admin\ExpenseDetail;
use App\Models\admin\LoanRequest;
use App\Models\admin\Membership;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            $totalMembershipFees1=Membership::value(DB::raw("SUM(jan_fees + jan_penalty + feb_fees + feb_penalty + march_fees +march_penalty + april_fees + april_penalty + may_fees + may_penalty + june_fees + june_penalty + july_fees + july_penalty + aug_fees + aug_penalty + sep_fees + sep_penalty + oct_fees)"));
            $totalMembershipFees2=Membership::value(DB::raw("SUM(oct_penalty+nov_fees+nov_penalty+dec_fees+dec_penalty)"));
            $totalMembershipFees=$totalMembershipFees1+$totalMembershipFees2;

            $totalInterest = UserLoanMgmt::where('tenuar_status', '=', 1)->sum('emi_amount');

            $totalPenalty = UserLoanMgmt::where('tenuar_status', '=', 1)->sum('penalty');

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

                   $penalty = UserLoanMgmt::where('tenuar_status', '=', 1)->where('request_id', '=', $loanAmountDetail['id'])
                       ->sum('penalty');

                   $profit=$profit+(($interestEmi-$originalEmi)*$emiCount)+$penalty;
               }
            }
            $expense = ExpenseDetail::sum('expense');

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


            $totalMembershipFees1=Membership::where('user_id','=',\Auth::user()->id)->value(DB::raw("SUM(jan_fees + jan_penalty + feb_fees + feb_penalty + march_fees +march_penalty + april_fees + april_penalty + may_fees + may_penalty + june_fees + june_penalty + july_fees + july_penalty + aug_fees + aug_penalty + sep_fees + sep_penalty + oct_fees)"));
            $totalMembershipFees2=Membership::where('user_id','=',\Auth::user()->id)->value(DB::raw("SUM(oct_penalty+nov_fees+nov_penalty+dec_fees+dec_penalty)"));
            $totalMembershipFees=$totalMembershipFees1+$totalMembershipFees2;

        }
        return view('admin.dashboard',get_defined_vars());
    }
}
