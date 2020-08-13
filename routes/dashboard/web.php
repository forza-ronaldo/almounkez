<?php
use Illuminate\Support\Facades\Route;
Route::prefix('dashboard')->name('dashboard.')->middleware(['auth','accountIsActivated'])->group(function () {
    Route::resource('/user', 'userController');
    Route::get('user/{user}/showFormSendMessage','userController@showFormSendMessage')->name('user.showFormSendMessage');
    Route::post('user/sendMessage/{user}','userController@sendMessage')->name('user.sendMessage');
});
