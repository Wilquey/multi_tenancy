<?php

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

Route::resource('posts', 'PostController');

Route::view('/404-tenant', 'errors.404-tenant')->name('404.tenant');

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
/*
 * Auth Custon Routes
*/
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reseting');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

// Registration Routes...
$this->group(['middleware' => 'not.domain.main'], function() {
    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    $this->post('register', 'Auth\RegisterController@register')->name('');
});

Route::get('/home', 'HomeController@index')->name('home');

