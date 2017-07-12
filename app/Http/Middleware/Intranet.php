<?php

namespace App\Http\Middleware;

use Closure;
use App\Settings;

class Intranet
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
        if(Settings::first()->ip != '...'){
            if($_SERVER['REMOTE_ADDR'] == Settings::first()->ip || $_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
                return $next($request);
            }
            else{
                return redirect('http://talalcontracting.com/');
            }
        }
        return $next($request);
    }
}
