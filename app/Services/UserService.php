<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use DB;

class UserService
{
    use ApiResponser;

    private $userObj;

    public function __construct(User $userObj)
    {
        $this->userObj = $userObj;
    }
    public function register($inputs)
    {
        $data = [
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => Hash::make($inputs['password']),
        ];
        $user = $this->userObj->create($data);

        
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
            $data['errors']['user'][] = __('user.usernotfound');
            return $data;
        }

        return $user;
    }
   
}
