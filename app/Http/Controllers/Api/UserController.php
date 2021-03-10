<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\signup;
use App\Http\Requests\User\login;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use App\Http\Resources\User\Resource as UserResource;

class UserController extends Controller
{
    use ApiResponser;

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function signup(signup $request)
    {
        $user = $this->userService->register($request->all());
        if(isset($user['errors']))
        {
            return $this->error($user);
        }else
        {
            $data =[
                'user' => new UserResource($user),
                'token' => $user->createToken('Laravel')->accessToken
            ];
            return $this->success($data, 200);
        }
    }   
    public function login(login $request)
    {
        $user = $this->userService->login($request->all());

        if(isset($user['errors']))
        {
            return $this->error($user);
        }else
        {
            $data =[
                'user' => new UserResource($user),
                'token' => $user->createToken('Laravel')->accessToken
            ];
            return $this->success($data, 200);
        }
    }
}
