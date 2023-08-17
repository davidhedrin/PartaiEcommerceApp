<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use App\Models\Transaction;

class AuthOwnerLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            $transId = $request->route('trans_id');
            $uuid = Uuid::fromString($transId);
            $transaction = Transaction::find($uuid);
    
            if($transaction){
                if (!$transaction || $transaction->user_id !== auth()->id()) {
                    session()->flush();
                    session()->flash('msgAlert', 'Ops... You have accessed a transaction that is not yours. We have to get you out.');
                    session()->flash('msgStatus', 'Info');
                    return redirect()->route('login');
                }
            }
        }catch(Exception $e){
        }
        
        return $next($request);
    }
}
