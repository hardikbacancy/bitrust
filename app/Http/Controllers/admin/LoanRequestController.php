<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\admin\AdminSetting;
use App\Models\admin\LoanRequest;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Illuminate\Http\Request;
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
            $loanRequest=LoanRequest::where('user_id','=',\Auth::user()->id)->get()->toArray();
        }
        else {
            $loanRequest = LoanRequest::all()->toArray();
        }
        foreach ($loanRequest as $key => $value) {
            $loanRequests = User::find($value['user_id'])->toArray();
            $loanRequest[$key]['name'] = $loanRequests['name'];
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
        $userDetails = User::all()->toArray();
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
            if(auth()->user()->hasRole('User')){
                $user_id=\Auth::user()->id;
                $requestAll=$request->all();
                $requestAll['user_id']=$user_id;
                LoanRequest::create($requestAll);
            }
            else{
                LoanRequest::create($request->all());
            }
            return redirect()->route(ADMIN . '.loan_request.index')->withSuccess("Successfully Added");
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
        $loanRequest = LoanRequest::findOrFail($id);
        $userDetails = User::all()->toArray();
        $adminSettings = AdminSetting::all()->toArray();
        return view('admin.loan_request.edit', get_defined_vars());
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
            $user_id = \Auth::user()->id;
            if ($request->request_status == '1') {
                $period = $request->tenuar_period;
                $loan_amount = $request->loan_amount;
                $interest_rate = $request->interest_rate;
                $emi_amount = ($loan_amount * $interest_rate) / 100 + $loan_amount;
                $emi_amount_per_month = $emi_amount / $period;
                $userLoanMgmtData = array();
                for ($i = 1; $i <= $period; $i++) {
                    $firstDay=date('Y-m-d',strtotime("first day of this month"));
                    $emi_date = date('Y-m-d', strtotime($i.'month', strtotime($firstDay)));
                    $userLoanMgmtData['user_id'] = $user_id;
                    $userLoanMgmtData['request_id'] = $id;
                    $userLoanMgmtData['emi_amount'] = $emi_amount_per_month;
                    $userLoanMgmtData['tenuar_date'] = $emi_date;
                    $userLoanMgmt = UserLoanMgmt::create($userLoanMgmtData);
                }
            }
            $loanRequest = LoanRequest::findOrFail($id);
            $loanRequest->update($request->all());
            return redirect()->route(ADMIN . '.loan_request.index')->withSuccess(trans('app.success_update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoanRequest::destroy($id);
        return back()->withSuccess(trans('app.success_destroy'));
    }

    public function loanDetails(Request $request, $requestId)
    {
        $userLoanMgmt = UserLoanMgmt::where('request_id', $requestId)->get()->toArray();
        return view('admin.loan_request.loandetails', get_defined_vars());
    }

    public function loanStatusUpdate(Request $request)
    {
        $userloanMgt = UserLoanMgmt::findOrFail($request->id);
        $userloanMgt->tenuar_status = $request->check_value;
        $userloanMgt->save();
        return json_encode($userloanMgt);
    }
}
