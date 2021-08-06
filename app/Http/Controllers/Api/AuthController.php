<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\Models\Token;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use  ApiResponse;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    public  function  register(RegisterRequest  $request): \Illuminate\Http\JsonResponse
    {

        $checkUserExist = User::where('email',$request->email)->count();
        if($checkUserExist > 0 ){
            return $this->error('This email already have an account with our protal.please login');
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->save();

        $credentials = request([$user->email, $user->password]);
        $token = auth()->attempt($credentials);

        $user['accessToken'] = $token;
        return $this->success($user,"Successfully Register.Please Login");

    }
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->error("unauthenticated user");
        }
        $user = auth()->user();
        $user['accessToken'] = $token;
        return $this->success($user,"Successfully Login.");
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return $this->success(auth()->user(),"Profile");
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return  $this->success(null,'Successfully logged out');

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
