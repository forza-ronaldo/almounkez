<?php
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){                                                                              //checkIsAdmin
    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth','accountIsActivated'])->group(function () {
        Route::resource('/powersManagement', 'powersManagementController');
        Route::put('/powersManagement/role_user/{row_id}', 'powersManagementController@updateRoleUser')->name('powersManagement.update.role_user');
        Route::get('/powersManagement/role_permission/{row_id}/edit', 'powersManagementController@showFormUpdateRolePermission')->name('powersManagement.show.form.update.role_permission');
        Route::put('/powersManagement/role_permission/{row_id}', 'powersManagementController@updateRolePermission')->name('powersManagement.update.role_permission');
        Route::resource('/user', 'userController');
        Route::get('user/{user}/showFormSendMessage','userController@showFormSendMessage')->name('user.showFormSendMessage');
        Route::post('user/sendMessage/{user}','userController@sendMessage')->name('user.sendMessage');
    });
});

