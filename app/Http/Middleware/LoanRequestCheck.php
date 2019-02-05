<?php

namespace App\Http\Middleware;

use Closure;

class LoanRequestCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user()->role!=0) {
            return $next($request);
        }
        else{
            $count=checkLoanMenu();
            if($count>0){
                return $next($request);
            }
            else{
                return redirect('/admin');
            }
        }
    }
}
