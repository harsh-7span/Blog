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
    Route::post('signup', 'AuthController@signup');
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout','AuthController@logout');
        Route::apiResource('books','BookController');
        Route::apiResource('authors','AuthorController');
        Route::delete('books/{id}/remove-image', 'BookController@removeImage');
        Route::post('books/{id}/remove-image', 'BookController@removeImage');
    });
    

