<?php
namespace App\Http\Controllers;
use App\Mail\AdminConfirmMail;
use App\Mail\NewUserVerificationMail;
use App\Mail\VerifyMail;
use App\Models\admin\AdminSetting;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Mail;
use Validator;

class UsersController extends Controller
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
            $users = User::whereIn('role', [0,4])->where('active', '=', 1)->orderBy('updated_at', 'desc')->get();
        }
        else{
            $users = User::whereIn('role', [0])->where('active', '=', 1)->orderBy('updated_at', 'desc')->get();
        }

        $adminSettings=AdminSetting::all()->toArray();
        return view('admin.users.index',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, User::rules());
        $userloanDetails=new User();
        $requestAll=$request->all();
        $user=User::create($requestAll);

        if($request->active=='1'){
            Mail::to($user->email)->send(new AdminConfirmMail($user));
            return redirect()->route(ADMIN.'.users.index')->withSuccess("User Added Successfully,email sent to username".' '.$user->username);

        }
        else if($request->active=='0'){
            $adminEmail="shashi.sagar@bacancytechnology.com";
            Mail::to($adminEmail)->send(new NewUserVerificationMail($user));
            return redirect()->route(ADMIN.'.pending_users.index')->withSuccess("User Added Successfully,alert email sent to you, please verify from here username".' '.$user->username);
        }
        else{
            return redirect()->route(ADMIN.'.users.index')->withSuccess("User Added Successfully");
        }
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
        $item = User::findOrFail($id);
        return view('admin.users.edit', compact('item'));
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
        $item = User::findOrFail($id);
        $item->update($request->all());
        return redirect()->route(ADMIN.'.users.index')->withSuccess(trans('app.success_update'));
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
