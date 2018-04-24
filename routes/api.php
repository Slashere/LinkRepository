<?php

Route::post('/user', 'Api\UserController@store')
    ->name('api_store_user');

Route::get('/token', 'TokenController@auth');

Route::put('/token', 'TokenController@refresh');

Route::delete('/token', 'TokenController@invalidate');

Route::middleware('auth:token', 'exper')->group(function () {

    Route::get('/link/{link}', 'Api\LinkController@show')
        ->name('api_show_link');

    Route::get('/mylinks', 'Api\LinkController@showMyLinks')
        ->name('api_show_mylink');

    Route::get('/links', 'Api\LinkController@index')
        ->name('api_show_links');

    Route::put('/link/{link}', 'Api\LinkController@update')
        ->name('api_update_link')
        ->middleware('can:api-update-link,link');

    Route::post('/link', 'Api\LinkController@store')
        ->name('api_create_link')
        ->middleware('can:api-create-link');

    Route::delete('/link/{link}', 'Api\LinkController@destroy')
        ->name('api_delete_link')
        ->middleware('can:api-delete-link,link');

    Route::get('/user/{user}', 'Api\UserController@show')
        ->name('api_show_user');

    Route::put('/user/{user}', 'Api\UserController@update')
        ->name('api_update_user')
        ->middleware('can:api-update-user,user');

    Route::delete('/user/{user}', 'Api\UserController@destroy')
        ->name('api_delete_user')
        ->middleware('can:api-delete-user,user');

});