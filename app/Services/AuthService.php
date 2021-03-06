<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use DB;

class AuthService
{
    use ApiResponser;

    private $userObj;

    public function __construct(User $userObj)
    {
        $this->userObj = $userObj;
    }
    public function register($inputs)
    {
        $inputs['password'] = Hash::make($inputs['password']);
        $user = $this->userObj->create($inputs);

        
        return $user;
    }
    public function login($inputs)
    {
        $user = $this->userObj->where('email',$inputs['email'])->first();

        if($user)
        {
            if (!\Hash::check($inputs['password'], $user->password)) {
                $data['errors']['user'][] = __('user.credentialsnotmatch');
                return $data;
            }
        }
        else {
            $data['errors']['user'][] = __('user.userNotFound');
            return $data;
        }

        return $user;
    }
    public function logout()
    {
        $accessToken = Auth::user()->token();

        \DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);
        $accessToken->revoke();
        $data['message'] = __('user.logoutSuccess');
        return $data;
    }
   
}
