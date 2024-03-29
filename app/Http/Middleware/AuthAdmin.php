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
        if(Auth::user()->role->id === 1 && Auth::user()->flag_active === 'Y'){
            if (empty(session("admin_otp"))) {
                return redirect()->route('otp-admin');
            } else {
                return $next($request);
            }
        }
        else{
            session()->flush();
            session()->flash('msgAlert', 'Ops... Anda tidak diijinkan untuk mengakses halaman tersebut. Maaf, kami harus mengeluarkan anda. Terimakasih!');
            session()->flash('msgStatus', 'Info');
            return redirect()->route('login');
        }
        return $next($request);
    }
}
