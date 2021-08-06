<?php

namespace App\Http\Middleware;

use App\Models\Token;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationRequest
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');
        $checkTokenExist = Token::where([
            'token' => $header,
            'revoked' => '1',
        ])->first();

        if(!$checkTokenExist){
            return $this->error("unauthenticated  user. please login");
        }

        Auth::loginUsingId($checkTokenExist->id);

        return $next($request);
    }
}
