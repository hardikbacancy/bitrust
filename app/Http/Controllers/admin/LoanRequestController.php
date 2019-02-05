<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\admin\AdminSetting;
use App\Models\admin\LoanRequest;
use App\Models\admin\Membership;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoanRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('User')){
            $count = Membership::
            join('users', 'users.id', '=', 'memberships.user_id')
                ->select('users.*')
                ->where('users.role', '=', 0)
                ->where('users.id', '=', \Auth::user()->id)
                ->count();
            $loanRequest=LoanRequest::where('user_id','=',\Auth::user()->id)->orderBy('updated_at', 'desc')->get()->toArray();
        }
        else {
            $count=1;
            $loanRequest = LoanRequest::orderBy('updated_at', 'desc')->get()->toArray();
        }
        foreach ($loanRequest as $key => $value) {
            $loanRequests = User::find($value['user_id'])->toArray();
            $loanRequest[$key]['name'] = $loanRequests['name'];

            $loan_amount=$value['loan_amount'];
            $emi_period=$value['tenuar_period'];
            $interest=$value['interest_rate'];
            $laon_amount_including_interest = floor($value['loan_amount'] * $value['interest_rate'] / 100 + $value['loan_amount']);
            $emi_amount = ($laon_amount_including_interest)/$emi_period;

            $LoanDetails = UserLoanMgmt::where('request_id', $value['id'])->
            where('user_id',$value['user_id'])->get()->toArray();
            $i = 0;
            foreach ($LoanDetails as $LoanDetail) {
                $status = $LoanDetail['tenuar_status'];
                if ($status == 1) {
                    $i++;
                }
            }
            if($i==$emi_period){
                $loanRequest[$key]['completed'] = "Completed";
            }
            else{
                $loanRequest[$key]['completed'] = "Processing";
            }
//            $paidEmiAmount = $emi_amount * $i;
//            $loanRequest[$key]['paidEmiAmount'] = floor($paidEmiAmount);
//            $loanRequest[$key]['remainningEmiAmount'] = floor($laon_amount_including_interest-$paidEmiAmount);


            $loanRequest[$key]['paidEmiAmount']=DB::table('user_loan_mgmts')
                ->where('user_id','=',$value['user_id'])->where('request_id','=',$value['id'])->where('tenuar_status','=',1)->sum('emi_amount');

            $loanRequest[$key]['remainningEmiAmount']=DB::table('user_loan_mgmts')
                ->where('user_id','=',$value['user_id'])->where('request_id','=',$value['id'])->where('tenuar_status','=',0)->sum('emi_amount');

        }

        return view('admin.loan_request.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->role!=0) {
            $userDetails = Membership::
            join('users', 'users.id', '=', 'memberships.user_id')
                ->select('users.*')
                ->where('users.role', '=', 0)
                ->groupBy('memberships.user_id')
                ->get()->toArray();
        }
        else{
            $count=checkLoanMenu();
            if($count==0){
                return redirect()->route(ADMIN . '.loan_request.index')->with('message','You do not have membership yet');
            }
        }
        $adminSettings = AdminSetting::all()->toArray();
        return view('admin.loan_request.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'loan_amount' => 'required|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route(ADMIN . '.loan_request.create')
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $userloanDetails=new User();
            $totalAvailBal=$userloanDetails->userLoanDetails();
            $interest=$userloanDetails->getInterest();
            $minLoanAmount=$userloanDetails->getMinLoanAmount();
            if($request->loan_amount>=$minLoanAmount) {
                if ($totalAvailBal >= ($request->loan_amount)) {
                    if (auth()->user()->hasRole('User')) {
                        $user_id = \Auth::user()->id;
                        $requestAll = $request->all();
                        $requestAll['user_id'] = $user_id;
                        $requestAll['interest_rate'] = $interest;
                        LoanRequest::create($requestAll);
                    } else {
                        $period = $request->tenuar_period;
                        $loan_amount = $request->loan_amount;
                        $interest_rate = $interest;
                        $requestAll = $request->all();
                        $requestAll['interest_rate'] = $interest;
                        $loanRequest=LoanRequest::create($requestAll);
                        if ($request->request_status == 1) {
                            $emi_amount = ($loan_amount * $interest_rate) / 100 + $loan_amount;
                            $emi_amount_per_month = $emi_amount / $period;

                            for ($i = 1; $i <= $period; $i++) {
                                $firstDay = date('Y-m-d', strtotime("first day of this month"));
                                $emi_date = date('Y-m-d', strtotime($i . 'month', strtotime($firstDay)));
                                $userLoanMgmtData['user_id'] = $loanRequest->user_id;
                                $userLoanMgmtData['request_id'] = $loanRequest->id;
                                $userLoanMgmtData['emi_amount'] = $emi_amount_per_month;
                                $userLoanMgmtData['tenuar_date'] = $emi_date;
                                $userLoanMgmt = UserLoanMgmt::create($userLoanMgmtData);
                            }
                        }

                    }
                    return redirect()->route(ADMIN . '.loan_request.index')->withSuccess("Successfully Added");
                } else {
                    return redirect()->route(ADMIN . '.loan_request.create')->with('message', 'Not sufficient available balance for loan request');
                }
            }
            else{
                return redirect()->route(ADMIN . '.loan_request.create')->with('message', 'Min Loan Amount Must be'.' '.$minLoanAmount.'$');

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userDetails = User::where('role','=',0)->get()->toArray();
        if(auth()->user()->hasRole('Superadmin|Admin')){
            $loanRequest = LoanRequest::findOrFail($id);
            $adminSettings = AdminSetting::all()->toArray();
            return view('admin.loan_request.edit', get_defined_vars());
        }
        else{
            $userId=\Auth::user()->id;
            $loanRequest = LoanRequest::findOrFail($id);
            if($userId==$loanRequest->user_id){
                $adminSettings = AdminSetting::all()->toArray();
                return view('admin.loan_request.edit', get_defined_vars());
            }
            else{
                return redirect('/admin');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'loan_amount' => 'required|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route(ADMIN . '.loan_request.create')
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $user_id = $request->user_id;
            $userloanDetails=new User();
            $interest=$userloanDetails->getInterest();

            if ($request->request_status == '1') {
                $userloanDetails=new User();
                $totalAvailBal=$userloanDetails->userLoanDetails();
                if($totalAvailBal>=($request->loan_amount)) {
                    $period = $request->tenuar_period;
                    $loan_amount = $request->loan_amount;
                    $interest_rate = $interest;
                    $emi_amount = ($loan_amount * $interest_rate) / 100 + $loan_amount;
                    $emi_amount_per_month = $emi_amount / $period;
                    $userLoanMgmtData = array();
                    for ($i = 1; $i <= $period; $i++) {
                        $firstDay = date('Y-m-d', strtotime("first day of this month"));
                        $emi_date = date('Y-m-d', strtotime($i . 'month', strtotime($firstDay)));
                        $userLoanMgmtData['user_id'] = $user_id;
                        $userLoanMgmtData['request_id'] = $id;
                        $userLoanMgmtData['emi_amount'] = $emi_amount_per_month;
                        $userLoanMgmtData['tenuar_date'] = $emi_date;
                        $userLoanMgmt = UserLoanMgmt::create($userLoanMgmtData);
                    }
                }
                else{
                    return back()->with('message', 'Not sufficient available balance for loan request');

                }
            }
            $loanRequest = LoanRequest::findOrFail($id);
            $loanRequest->update($request->all());
            return redirect()->route(ADMIN . '.loan_request.index')->withSuccess(trans('app.success_update'));
        }
    }

    public function destroy($id)
    {
        UserLoanMgmt::where("request_id","=",$id)->delete();
        LoanRequest::destroy($id);
        return back()->withSuccess(trans('app.success_destroy'));
    }

    public function loanDetails(Request $request, $requestId)
    {
        if(auth()->user()->hasRole('Superadmin|Admin')){
            $loanRequest = LoanRequest::where('id', $requestId)->get()->toArray();
            $userLoanMgmt = UserLoanMgmt::where('request_id', $requestId)->get()->toArray();
            return view('admin.loan_request.loandetails', get_defined_vars());
        }
        else{
            $loanRequest = LoanRequest::where('id', $requestId)->where('user_id','=',\Auth::user()->id)->get()->toArray();
            $userLoanMgmt = UserLoanMgmt::where('request_id', $requestId)->where('user_id','=',\Auth::user()->id)->get()->toArray();
            if(!empty($userLoanMgmt) && !empty($loanRequest)){
                return view('admin.loan_request.loandetails', get_defined_vars());
            }
            else{
                return redirect('/admin');
            }
        }
    }

    public function loanStatusUpdate(Request $request)
    {
        if($request->check_value==1) {
            $emi_paid_date = date('Y-m-d');
        }
        else{
            $emi_paid_date = NULL;
        }
        $userloanMgt = UserLoanMgmt::findOrFail($request->id);
        $userloanMgt->tenuar_status = $request->check_value;
        $userloanMgt->emi_paid_date = $emi_paid_date;
        $userloanMgt->penalty = $request->penalty;
        $userloanMgt->save();
        return json_encode($userloanMgt);
    }
    public function deleteEmi(Request $request){
        UserLoanMgmt::where("id","=",$request->id)->delete();
        return json_encode("1");
    }

}
