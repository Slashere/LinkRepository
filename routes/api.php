<?php

Route::post('/user', 'Api\UserController@store')
    ->name('api_store_user');

Route::get('/token', 'TokenController@auth');

Route::put('/token', 'TokenController@refresh');

Route::delete('/token', 'TokenController@invalidate');

Route::middleware('auth.jwt')->group(function () {

    Route::get('/link/{link}', 'Api\LinkController@show')
        ->name('api_show_link');

    Route::put('/link/{link}', 'Api\LinkController@update')
        ->name('api_update_link')
        ->middleware('can:update-link,link');

    Route::post('/link', 'Api\LinkController@store')
        ->name('api_create_link')
        ->middleware('can:create-link');

    Route::delete('/link/{link}', 'Api\LinkController@destroy')
        ->name('api_delete_link')
        ->middleware('can:delete-link,link');

    Route::get('/user/{user}', 'Api\UserController@show')
        ->name('api_show_user');

    Route::put('/user/{user}', 'Api\UserController@update')
        ->name('api_update_user')
        ->middleware('can:update-user,user');

    Route::delete('/user/{user}', 'Api\UserController@destroy')
        ->name('api_delete_user')
        ->middleware('can:delete-user,user');

});