<?php

namespace App\Http\Middleware;
use Closure;
use Auth;
class Is_admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        //echo "<pre>";
        //print_r(Auth::user());exit;
        if(Auth::user()->roll_id == 1 || Auth::user()->roll_id == 3){
           return $next($request);
		}
		else {
            return redirect('logout');
        } 
            
    }
}
