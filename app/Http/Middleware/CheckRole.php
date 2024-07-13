<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function accessToken(Request $request, Closure $next, $role): Response
    {
        if($request.header('Authorization')){
            $token= explode($request.header('Authorization'), '');
            $tokens= $_SERVER["tokens"];
            foreach($tokens as $key=>$tok){
                if(($tok['token'] == $token[1])){
                    if($token[0] == $role){
                        return $next($request);
                    }else{
                        unset($tokens[$key]);
                        $_SERVER["tokens"]= $tokens;
                        return response()->json(['message' => 'Unauthorized'], 401 );                    
                    }
                }
            }
            
        }
        return response()->json(['message' => 'Unauthorized'], 401 );
    }
}
