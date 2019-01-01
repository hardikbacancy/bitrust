<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\User;
use App\UserLoanMgmt;
use Illuminate\Http\Request;
use App\LoanRequest;

class UserLoanMgmtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userLoanMgmt = UserLoanMgmt::all()->toArray();
        return view('admin.loan_management.index', compact('userLoanMgmt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userDetails=User::all()->toArray();
        return view('admin.loan_management.create',get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        UserLoanMgmt::create($request->all());
        //return back()->withSuccess(trans('app.success_store'));
        return redirect()->route(ADMIN.'.loan_management.index')->withSuccess("Successfully Added");
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
        $userLoanMgmt = UserLoanMgmt::findOrFail($id);
        $userDetails=User::all()->toArray();
        return view('admin.loan_management.edit',get_defined_vars());
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
        $userLoanMgmt = UserLoanMgmt::findOrFail($id);
        $userLoanMgmt->update($request->all());
        //return back()->withSuccess(trans('app.success_update'));
        return redirect()->route(ADMIN.'.loan_management.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserLoanMgmt::destroy($id);
        return back()->withSuccess(trans('app.success_destroy'));
    }
}
