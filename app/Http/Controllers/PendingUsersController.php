<?php
namespace App\Http\Controllers;
use App\Mail\AdminConfirmMail;
use App\Mail\VerifyMail;
use App\Models\admin\AdminSetting;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Mail;
use Validator;

class PendingUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->role=='5') {
            $users = User::whereIn('role', [0,4])->where('active', '=', 0)->orderBy('updated_at', 'desc')->get();
        }
        else{
            $users = User::whereIn('role', [0])->where('active', '=', 0)->orderBy('updated_at', 'desc')->get();
        }

        $adminSettings=AdminSetting::all()->toArray();
        return view('admin.pending_users.index',get_defined_vars());
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = User::findOrFail($id);
        return view('admin.pending_users.edit', compact('item'));
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
        $this->validate($request, User::rules(true, $id));
        $user = User::findOrFail($id);
        $user->update($request->all());

        if($request->active=='1') {
            Mail::to($user->email)->send(new AdminConfirmMail($user));
            return redirect()->route(ADMIN.'.users.index')->withSuccess("Verified Successfully,email sent to username ".' '.$user->username);

        }
        return redirect()->route(ADMIN.'.pending_users.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return back()->withSuccess(trans('app.success_destroy'));
    }
}
