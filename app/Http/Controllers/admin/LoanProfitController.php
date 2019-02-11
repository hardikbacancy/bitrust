<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\AdminSetting;
use App\Models\admin\LoanRequest;
use App\Models\admin\Membership;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class LoanProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loanProfit()
    {
        return view('admin.dashboard_detail.index');
    }

    public function loanProfitPostAjax(Request $request)
    {
        $query = UserLoanMgmt::select('user_loan_mgmts.*', 'users.email', 'loan_requests.interest_rate', 'loan_requests.loan_amount', 'loan_requests.tenuar_period')->join('users', 'users.id', '=', 'user_loan_mgmts.user_id')
            ->join('loan_requests', 'user_loan_mgmts.request_id', '=', 'loan_requests.id')
            ->where('tenuar_status', '=', 1);

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $loanEmiDetails = $query->whereDate('emi_paid_date', '>=', $start_date)->whereDate('emi_paid_date', '<', $end_date)->orderBy('user_loan_mgmts.updated_at', 'desc')->get();
        } else if (!empty($request->start_date)) {
            $start_date = $request->start_date;
            $start_date = date('Y-m-d', strtotime($start_date));
            $loanEmiDetails = $query->whereDate('emi_paid_date', '>=', $start_date)->orderBy('user_loan_mgmts.updated_at', 'desc')->get();
        } else if (!empty($request->end_date)) {
            $end_date = $request->end_date;
            $end_date = date('Y-m-d', strtotime($end_date));
            $loanEmiDetails = $query->whereDate('emi_paid_date', '<=', $end_date)->orderBy('user_loan_mgmts.updated_at', 'desc')->get();
        } else {
            $loanEmiDetails = $query->orderBy('user_loan_mgmts.updated_at', 'desc')->get();
        }

        return Datatables::of($loanEmiDetails)
            ->addColumn('amount_per_month', function ($loanEmiDetails) {
                return ceil($loanEmiDetails->loan_amount / $loanEmiDetails->tenuar_period);
            })
            ->addColumn('interest_amount', function ($loanEmiDetails) {
                return ceil($loanEmiDetails->emi_amount - ($loanEmiDetails->loan_amount / $loanEmiDetails->tenuar_period));
            })
            ->addColumn('profit_amount', function ($loanEmiDetails) {
                return ceil($loanEmiDetails->emi_amount - ($loanEmiDetails->loan_amount / $loanEmiDetails->tenuar_period) + $loanEmiDetails->penalty);
            })
            ->addColumn('penalty', function ($loanEmiDetails) {
                if (!empty($loanEmiDetails->penalty)) {
                    return $loanEmiDetails->penalty;
                } else {
                    return "-";
                }

            })
            ->make(true);
    }
}
