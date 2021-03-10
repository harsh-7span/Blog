<?php

use App\Http\Requests\User\signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
    Route::post('signup', 'UserController@signup');
    Route::post('login', 'UserController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('books','BookController');
    });
    

