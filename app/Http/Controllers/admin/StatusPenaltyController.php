<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\admin\LoanRequest;
use App\Models\admin\UserLoanMgmt;
use Illuminate\Http\Request;


class StatusPenaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statusPenalty(Request $request)
    {
        foreach($request->check_select as $key=>$value){
            $partsId = explode('_',$value);
            if(!empty($partsId[0])){
                $userLoan = UserLoanMgmt::find($partsId[0]);
                $emi_paid_date = date('Y-m-d');
                $userLoan->emi_paid_date = $emi_paid_date;
                $userLoan->tenuar_status = '1';
                $userLoan->save();
            }
            if(!empty($partsId[1])) {
                $userLoan = UserLoanMgmt::find($partsId[0]);
                $userLoan->penalty = $partsId[1];
                $userLoan->save();
            }
        }
        $loanMgt=UserLoanMgmt::where('request_id','=',$request->requestId)->get()->toArray();
        return json_encode($loanMgt);
    }
}
