<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
       $authorization= explode(" ",$request->header('authorization'));
       Log::info(''.$authorization[0].' '.$authorization[1]);
       if(isset($_SESSION['tokens'])){
        Log::info($_SESSION['tokens']);
        if($authorization){
            $token= $authorization;
            $tokens= $_SESSION["tokens"];
            foreach($tokens as $key=>$tok){
                if(($tok['token'] == $token[1])){
                    if($token[0] == $role){
                        return $next($request);
                    }else{
                        unset($tokens[$key]);
                        $_SESSION["tokens"]= $tokens;
                        return response()->json(['message' => 'Unauthorized'], 401 );                    
                    }
                }
            }
            
        }
       }
        return response()->json(['message' => 'unauthorized'], 401 );
    }
}
