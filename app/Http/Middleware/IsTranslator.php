<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Response;

class IsTranslator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::user() &&  Auth::user()->istranslator == 1 || Auth::user()->isadmin == 1) {
            return $next($request);
       }
         return response()->json([
           'status'=>true,
            'message' => 'Bu alana sadece çevirmenler ulaşabilir'
         ]);
    }
}
