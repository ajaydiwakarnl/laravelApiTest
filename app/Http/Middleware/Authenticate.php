<?php

namespace App\Http\Middleware;

use App\Models\Token;
use App\Traits\ApiResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;
class Authenticate extends Middleware
{
    use ApiResponse;

    /**
     * @param Request $request
     * @param Closure $next
     * @param string[] ...$guards
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $header = $request->header('Authorization');

        if(!$header){
            return $this->error("unauthenticated  user. please login");
        }
        return $next($request);
    }

}
