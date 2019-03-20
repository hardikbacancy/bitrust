<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\admin\LoanRequest;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use Yajra\Datatables\Facades\Datatables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        return view('admin.report');
    }

    public function reportList(Request $request)
    {
        $start_date = $end_date = "";
        if (!empty($request->start_date)) {
            $start_date = $request->start_date;
            $start_date = date('Y-m-d', strtotime($start_date));
        } 
        if (!empty($request->end_date)) {
            $end_date = $request->end_date;
            $end_date = date('Y-m-d', strtotime($end_date));            
        }
            // $loanRequest = LoanRequest::where('request_status', '=', 1)->orderBy('updated_at', 'desc')->get()->toArray();
           
            $rname = $email = '';
            if(!empty($request->name)){
                $rname = $request->name;
            }
            if(!empty($request->email)){
                $email = $request->email;
            }
            $query =  LoanRequest::where('request_status', '=', 1);
            //$query->where('request_status', '=', 1);
            $query->join('users', 'users.id', '=', 'loan_requests.user_id');

            //$query->where('name', 'like', 'bacancy');
            if($start_date) $query->whereDate('loan_requests.created_at', '>=', $start_date);
            if($end_date) $query->whereDate('loan_requests.created_at', '<=', $end_date);
            if($rname) $query->where('users.name', 'like','%'.$rname.'%');
            if($email) $query->where('users.email', 'like','%'.$email.'%');

            $query->orderBy('loan_requests.updated_at', 'desc');

            $loanRequest = $query->get()->toArray();
       
      
        foreach ($loanRequest as $key => $value) {
            $loanRequests = User::find($value['user_id'])->toArray();
            $loanRequest[$key]['loan_id'] = $value['id'];
            $loanRequest[$key]['name'] = $loanRequests['name'];
            $loanRequest[$key]['email'] = $loanRequests['email'];
            $loan_amount = $value['loan_amount'];
            $emi_period = $value['tenuar_period'];
            $interest = $value['interest_rate'];
            $laon_amount_including_interest = floor($value['loan_amount'] * $value['interest_rate'] / 100 + $value['loan_amount']);
            $loanRequest[$key]['laon_amount_including_interest'] = $laon_amount_including_interest;
            $emi_amount = ($laon_amount_including_interest) / $emi_period;
            $loanRequest[$key]['emi_amount'] = floor($emi_amount);
            $LoanDetails = UserLoanMgmt::where('request_id', $value['id'])->
            where('user_id', $value['user_id'])->get()->toArray();

            $loanRequest[$key]['created_date'] = date('Y-m-d', strtotime($value['created_at']));

            $i = 0;
            foreach ($LoanDetails as $LoanDetail) {
                $status = $LoanDetail['tenuar_status'];
                if ($status == 1) {
                    $i++;
                }
            }
            if ($i == $emi_period) {
                $loanRequest[$key]['completed'] = "Completed";
            } else {
                $loanRequest[$key]['completed'] = "Processing";
            }
//            $paidEmiAmount = $emi_amount * $i;
//            $loanRequest[$key]['paidEmiAmount'] = floor($paidEmiAmount);
//            $loanRequest[$key]['remainningEmiAmount'] = floor($laon_amount_including_interest - $paidEmiAmount);
            $loanRequest[$key]['paidEmiAmount']=DB::table('user_loan_mgmts')
                ->where('user_id','=',$value['user_id'])->where('request_id','=',$value['id'])->where('tenuar_status','=',1)->sum('emi_amount');

            $loanRequest[$key]['remainningEmiAmount']=DB::table('user_loan_mgmts')
                ->where('user_id','=',$value['user_id'])->where('request_id','=',$value['id'])->where('tenuar_status','=',0)->sum('emi_amount');
        }
        //print_r($loanRequest);die;
        function arrayToCollection($loanRequest)
        {
            foreach ($loanRequest as $key => $value) {
                if (is_array($value)) {
                    $value = arrayToCollection($value);
                    $loanRequest[$key] = $value;
                }
            }
            return collect($loanRequest);
        }

        $loanRequest_1 = arrayToCollection($loanRequest);

        return Datatables::of($loanRequest_1)
            ->make(true);
    }

    public function checkData(Request $request){
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $loanRequest = LoanRequest::where('request_status', '=', 1)->whereDate('created_at', '>', $start_date)->whereDate('created_at', '<=', $end_date)->get()->toArray();
        } else if (!empty($request->start_date)) {
            $start_date = $request->start_date;
            $start_date = date('Y-m-d', strtotime($start_date));
            $loanRequest = LoanRequest::where('request_status', '=', 1)->whereDate('created_at', '>', $start_date)->get()->toArray();
        } else if (!empty($request->end_date)) {
            $end_date = $request->end_date;
            $end_date = date('Y-m-d', strtotime($end_date));
            $loanRequest = LoanRequest::where('request_status', '=', 1)->whereDate('created_at', '<=', $end_date)->get()->toArray();
        } else {
            $loanRequest = LoanRequest::where('request_status', '=', 1)->get()->toArray();
        }
        return json_encode($loanRequest);
    }
}
