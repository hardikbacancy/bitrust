<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
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
        foreach($request->dataValue as $key=>$value){
            $partsId = explode('_', $value['name']);
            if($partsId[0]=='penalty'){
                $id=$partsId[1];
                if(!empty($value['value'])){
                    $penalty = UserLoanMgmt::find($id);
                    $penalty->penalty = $value['value'];
                    $penalty->save();
                }
            }
        }
        if(!empty($request->check_select)) {
            foreach ($request->check_select as $key => $value) {
                $emi_paid_date = date('Y-m-d');
                $userLoan = UserLoanMgmt::find($value);
                $userLoan->emi_paid_date = $emi_paid_date;
                $userLoan->tenuar_status = '1';
                $userLoan->save();
            }
        }

        return json_encode($request->dataValue);
    }
}
