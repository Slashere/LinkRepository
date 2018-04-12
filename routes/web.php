<?php

Route::middleware('checkstatus')->group(function () {

    Route::get('/password/reset/{token}/{email}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

    Auth::routes();

    Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser')->name('user.verify');

    Route::get('/', 'MainController@index')->name('main');

    Route::get('/gallery', 'LinkController@gallery')->name('gallery');

    Route::get('/link/{link}', 'LinkController@show')
        ->name('show_link');

    Route::get('/user/{user}', 'UserController@show')
        ->name('show_user');

    Route::post('/send/code/{id}', 'VerifyUserController@updateExpiredTime')->name('send_code');

    Route::middleware('auth')->group(function () {

        Route::get('/home', 'HomeController@index')
            ->name('auth');

        Route::get('/admin', 'UserController@admin')
            ->name('admin_panel')
            ->middleware('admin');

        Route::delete('/user/delete/{user}', 'UserController@destroy')
            ->name('delete_user')
            ->middleware('can:delete-user,user');

        Route::get('/mylinks', 'LinkController@index')
            ->name('list_links');

        Route::get('/create', 'LinkController@create')
            ->name('create_link')
            ->middleware('can:create-link');

        Route::post('/create', 'LinkController@store')
            ->name('store_link')
            ->middleware('can:create-link');

        Route::get('/edit/{link}', 'LinkController@edit')
            ->name('edit_link')
            ->middleware('can:update-link,link');

        Route::post('/edit/{link}', 'LinkController@update')
            ->name('update_link')
            ->middleware('can:update-link,link');

        Route::delete('/delete/{link}', 'LinkController@destroy')
            ->name('delete_link')
            ->middleware('can:delete-link,link');

        Route::get('/user/edit/{user}', 'UserController@edit')
            ->name('edit_user')
            ->middleware('can:update-user,user');

        Route::post('/user/edit/{user}', 'UserController@update')
            ->name('update_user')
            ->middleware('can:update-user,user');
    });
});
