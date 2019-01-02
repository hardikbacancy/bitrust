<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\admin\AdminSetting;
use App\User;
use Illuminate\Http\Request;
use App\LoanRequest;

class LoanRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loanRequest = LoanRequest::all()->toArray();
        foreach($loanRequest as $key=>$value){
            $loanRequests=User::find($value['user_id'])->toArray();
            $loanRequest[$key]['name']=$loanRequests['name'];
        }
        return view('admin.loan_request.index',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userDetails=User::all()->toArray();
        $adminSettings=AdminSetting::all()->toArray();
        return view('admin.loan_request.create',get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        LoanRequest::create($request->all());
        //return back()->withSuccess(trans('app.success_store'));
        return redirect()->route(ADMIN.'.loan_request.index')->withSuccess("Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loanRequest = LoanRequest::findOrFail($id);
        $userDetails=User::all()->toArray();
        $adminSettings=AdminSetting::all()->toArray();
        return view('admin.loan_request.edit',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->request_status=='1'){
           $period=$request->tenuar_period;

        }
        $loanRequest = LoanRequest::findOrFail($id);
        $loanRequest->update($request->all());
        //return back()->withSuccess(trans('app.success_update'));
        return redirect()->route(ADMIN.'.loan_request.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoanRequest::destroy($id);
        return back()->withSuccess(trans('app.success_destroy'));
    }
}
