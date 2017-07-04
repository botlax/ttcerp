<?php

namespace App\Http\Middleware;

use Closure;

class Spectator
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
        if($request->user()->isSpectator()){
            flash('You are not authorized to access that page.')->error();
            return redirect('/');
        }
        return $next($request);
    }
}
