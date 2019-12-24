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
Route::post('login', 'API\UserController@login');

Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function()
{
    Route::post('details', 'API\UserController@details');

    Route::get('feed','API\FeedController@index');

    Route::post('proposition','API\PropositionController@store');

    Route::post('vote','API\VoteController@store');

    Route::get('propositions','API\PropositionController@index');

    Route::post('comments','API\CommentController@store');

    Route::patch('comments/update','API\CommentController@update');

    Route::delete('comments/{id}/delete','API\CommentController@delete');

    Route::get('satisfactions','API\ProjectController@satisfactions');

});


