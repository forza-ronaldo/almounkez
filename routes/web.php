<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('accountIsActivated');

Route::get('accountDisabled','verifyController@showInterfaceAccountDisabled')->name('accountDisabled');
Route::get('verify/{token}', 'verifyController@verify')->name('verify');
Route::post('reSendEmailVerified/{user}', 'verifyController@reSendEmailVerified')->name('reSendEmailVerified');

Route::get('resetPassword', 'resetPasswordController@showResetPasswordForm')->name('showResetPasswordForm');
Route::post('searchYourAccount', 'resetPasswordController@searchYourAccount')->name('searchYourAccount');
Route::get('showSetNewPassword/{token_reset_password}', 'resetPasswordController@showsetNewPassword')->name('showSetNewPassword');
Route::post('setNewPassword/{token_reset_password}', 'resetPasswordController@setNewPassword')->name('setNewPassword');
Route::middleware('auth')->group(function () {
    Route::middleware(['accountIsActivated'])->group(function () {
        Route::resource('user', 'userController')->only('edit', 'update');
    });
});
