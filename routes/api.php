<?php

Route::post('/user', 'Api\UserController@store')
    ->name('api_store_user');

Route::post('/account', 'AccountController@index')
    ->name('api_create_user');

Route::get('/token', 'TokenController@auth');
Route::put('/token/refresh', 'TokenController@refresh');
Route::get('/token/invalidate', 'TokenController@invalidate');

Route::get('/link/{link}', 'Api\LinkController@show')
    ->name('api_show_link');

Route::middleware('auth:api')->group(function () {

    Route::put('/link/{link}', 'Api\LinkController@update')
        ->name('api_update_link');

    Route::get('/user/{user}', 'Api\UserController@show')
        ->name('api_show_user');

    Route::put('/user/{user}', 'Api\UserController@update')
        ->name('api_update_user')
        ->middleware('can:update-user,user');

    Route::delete('/user/{user}', 'Api\UserController@destroy')
        ->name('api_delete_user')
        ->middleware('can:delete-user,user');

});