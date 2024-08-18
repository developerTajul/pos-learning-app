<?php

namespace App\Http\Middleware;

use App\Helper\JWTHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {    

        // Try to get the token from the header
        $token = $request->header('token');

        // If the token is not in the header, try to get it from the cookies
        if (!$token) {
            $token = $request->cookie('token');
        }
        
        $result = JWTHelper::verifyToken($token);


        if( $result === 'unauthorised' ){
            return redirect('/login');
        }else{
            $request->headers->set('user_id', $result->user_id);
            $request->headers->set('user_email', $result->user_email);
    
            return $next($request);
        }


    }
}
