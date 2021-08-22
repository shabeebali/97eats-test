<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Firebase\JWT\JWT;

class TokenAuth
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
        $token = $request->bearerToken();
        $key = 'Laravel-97eats';
        //$decoded = JWT::decode($token, $key, array('HS256'));
        $tokenModel = \App\Models\UserToken::where('token',$token)->first();
        if($tokenModel) {
            $user = $tokenModel->user;
            $request->setUserResolver(function() use ($user) {
                return $user;
            });
            return $next($request);
        } else {
            return response([
                'message' => 'Unauthenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }
        
    }
}
