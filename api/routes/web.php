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
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::get('/{provider}', 'SocialAuthController@redirectToProvider');
    Route::get('/{provider}/callback', 'SocialAuthController@handleProviderCallback');
});
Route::get('/meetings/zoom/redirect', 'Zoom\\ZoomController@redirectToZoom');
Route::get('/meetings/zoom/callback', 'Zoom\\ZoomController@handleCallback');
