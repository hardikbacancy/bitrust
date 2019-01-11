<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $type = 'csv';
        if ($request->isMethod('post')) {
            $query = DB::table('loan_requests')->where('request_status', '=', 1);
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $start_date = date('Y-m-d', strtotime($start_date));
                $end_date = date('Y-m-d', strtotime($end_date));
                $query->whereDate('created_at', '>', $start_date);
                $query->whereDate('created_at', '<=', $end_date);
            } else if (!empty($request->start_date)) {
                $start_date = $request->start_date;
                $start_date = date('Y-m-d', strtotime($start_date));
                $query->whereDate('created_at', '>=', $start_date);
            } else if (!empty($request->end_date)) {
                $end_date = $request->end_date;
                $end_date = date('Y-m-d', strtotime($end_date));
                $query->whereDate('created_at', '<=', $end_date);
            } else {

            }
            $data = $query->get()->toArray();
            $data = json_decode(json_encode($data), True);
            $reportArray = array();
            $finalreportArray = array();
            foreach ($data as $key => $value) {
                $userDetails = User::find($value['user_id'])->toArray();
                $reportArray['request_id'] = $userDetails['id'];
                $reportArray['name'] = $userDetails['name'];
                $reportArray['email'] = $userDetails['email'];
                $loan_amount=$value['loan_amount'];
                $emi_period=$value['tenuar_period'];
                $interest=$value['interest_rate'];
                $reportArray['loan_amount'] = $loan_amount;
                $reportArray['emi_period'] =$emi_period;
                $reportArray['interest_rate'] = $interest;
                $laon_amount_including_interest = floor($value['loan_amount'] * $value['interest_rate'] / 100 + $value['loan_amount']);
                $reportArray['total_loan(including interest)'] = $laon_amount_including_interest;
                $emi_amount = ($laon_amount_including_interest)/$emi_period;
                $reportArray['emi_amount'] = floor($emi_amount);
                $LoanDetails = UserLoanMgmt::where('request_id', $value['id'])->
                    where('user_id',$value['user_id'])->get()->toArray();
                $i = 0;
                foreach ($LoanDetails as $LoanDetail) {
                    $status = $LoanDetail['tenuar_status'];
                    if ($status == 1) {
                        $i++;
                    }
                }
                $paidEmiAmount = $emi_amount * $i;
                $remainingEmiAmount = $laon_amount_including_interest - $paidEmiAmount;
                $reportArray['paid_emi_amount'] = floor($paidEmiAmount);
                $reportArray['ramainning_emi_amount'] = floor($remainingEmiAmount);
                $finalreportArray[] = $reportArray;
            }
            return Excel::create('loan_requests', function ($excel) use ($finalreportArray) {
                $excel->sheet('mySheet', function ($sheet) use ($finalreportArray) {
                    $sheet->fromArray($finalreportArray);
                });
            })->download($type);
        }
        return view('admin.report');
    }
}
