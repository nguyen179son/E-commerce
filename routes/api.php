<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/comment','CommentsController@store');
Route::delete('/comment/{id}','CommentsController@destroy');
Route::put('/comment/{id}','CommentsController@update');
Route::get('/comment/list','CommentsController@show');


Route::post('/like','LikesController@store');
Route::post('/unlike','LikesController@destroy');
Route::get('/like/list','LikesController@show');