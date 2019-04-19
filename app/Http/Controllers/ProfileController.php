<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = User::findOrFail($id);
        return view('admin.profile', compact('item'));
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
        //Log::info('user: '. print_r( $request->all() )   );
        if(!empty(\Auth::user()->id) && \Auth::user()->role=='0'){
            $this->validate($request, User::rules_auth(true, $id));
            $item = User::findOrFail($id);
            $item->update($request->all());
        }
        else if(!empty(\Auth::user()->id) && \Auth::user()->role!='0'){
            $this->validate($request, User::rules_super_auth(true, $id));
            $item = User::findOrFail($id);
            $item->update($request->all());
        }
        else{
            $this->validate($request, User::rules(true, $id));
            $item = User::findOrFail($id);
            $item->update($request->all());
        }


        //update the auth, will needed for refresh UI
        \Auth::user()->update(['name' => $request->name]);
        \Auth::user()->update(['email' => $request->email]);

        return back()->withSuccess(trans('app.success_update'));
    }
}
