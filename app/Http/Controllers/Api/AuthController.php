<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\Models\Token;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\GenerateToken;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use GenerateToken,ApiResponse;


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

        $token = new Token();
        $token->token = $this->createToken();
        $token->user_id = $user->id;
        $token->save();

        $user['accessToken'] = $token->token;
        return $this->success($user,"Successfully Register.Please Login");

    }

    public  function  login(LoginRequest $request){

        $email = $request->input('email');
        $password = $request->input('password');

        $credential = User::where('email',$email)->first();

        if(!$credential || !Hash::check($password,$credential->password)){
            return $this->error('Invalid credentials');
        }
        $updateToken = Token::where('user_id',$credential->id)->first();
        $updateToken->token = $this->createToken();
        $updateToken->revoked = "1";
        $updateToken->save();

        $credential['accessToken'] = $updateToken->token;
        return $this->success($credential,'Successfully Login');
    }

    public function  logout(){
        Auth::logout();
    }
}
