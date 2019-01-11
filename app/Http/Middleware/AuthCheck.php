<?php
namespace App\Http\Middleware;
use App\Models\admin\LoanRequest;
use Closure;

class AuthCheck
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
        if (request()->route('id') == \Auth::user()->id) {
            return $next($request);
        }
        else{
            return redirect('/admin');
        }
    }
}
