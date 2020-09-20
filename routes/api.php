<?php

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

//Route::middleware('Auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware'=>'JwtMiddleware'], function () {
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/add-new-todo', 'TodoController@createTodo');
    Route::get('/all-todos/{id}', 'TodoController@getAllTodos');
    Route::delete('/destroy/{id}', 'TodoController@destroy');
    Route::get('/get-todo/{id}', 'TodoController@getTodo');
    Route::post('/update-todo/', 'TodoController@updateTodo');
});
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/signup', 'AuthController@signup');
});
