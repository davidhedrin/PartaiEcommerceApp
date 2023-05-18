<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->user_type === 'ADM' && Auth::user()->flag_active === 'Y'){
            return $next($request);
        }
        else{
            session()->flush();
            //session()->flash('msgExcLogin', 'Ops... Anda tidak diijinkan untuk mengakses halaman tersebut. Maaf, kami harus mengeluarkan anda. Terimakasih!');
            return redirect()->route('login');
        }
        return $next($request);
    }
}
