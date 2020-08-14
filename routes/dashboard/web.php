<?php
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth','accountIsActivated'])->group(function () {
        Route::resource('/admin', 'adminController');
        Route::resource('/user', 'userController');
        Route::get('user/{user}/showFormSendMessage','userController@showFormSendMessage')->name('user.showFormSendMessage');
        Route::post('user/sendMessage/{user}','userController@sendMessage')->name('user.sendMessage');
    });
});

