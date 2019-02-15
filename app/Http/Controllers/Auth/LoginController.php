<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/' . ADMIN;


    public function authenticated(Request $request, $user)
    {
        if ($user->email_verified_at=='0') {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $user = \App\User::where(function($query) use ($request) {
            return $query->where('email', '=', $request->email)
                ->orWhere('username', '=', $request->username);
        })->get();

        if ($user->isEmpty()) {
            // The user is doesnt exist
            return redirect("/login")
                ->withInput($request->only('email', 'remember'))
                ->withWarning('Your account is not registered');
        }

        $user = \App\User::where('active', '=', 1)

            ->where(function($query) use ($request) {
                return $query->where('email', '=', $request->email)
                    ->orWhere('username', '=', $request->username);
            })
            ->where('email_verified_at', '=', 1)
            ->get();

        if ($user->isEmpty()) {
            // The user is exist but inactive
            return redirect("/login")
                ->withInput($request->only('username', 'remember'))
                ->withWarning('Your account is inactive or username not verified');
        }

        //try login with password
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'username';

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }
    public function username()
    {
        return 'username';
    }

}
