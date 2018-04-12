<?php

Route::post('/user', 'API\UserController@store')
    ->name('api_store_user');

Route::get('/token', 'TokenController@auth');
Route::put('/token/refresh', 'TokenController@refresh');
Route::get('/token/invalidate', 'TokenController@invalidate');

Route::middleware('auth:api')->group(function () {

    Route::post('/account', 'AccountController@index');

    Route::get('/user/{user}', 'API\UserController@show')
        ->name('api_show_user');

    Route::get('/show/{link}', 'API\LinkController@show')
        ->name('api_show_link')
        ->middleware('show-private-link', 'link');

    Route::put('/user/{user}', 'API\UserController@update')
        ->name('api_update_user')
        ->middleware('can:update-user,user');


    Route::delete('/user/{user}', 'API\UserController@destroy')
        ->name('api_delete_user')
        ->middleware('can:delete-user,user');

});