<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
  'as' => 'home',
  'uses' => 'HomeController@index'
));

/* Authentication and Authorization Routes */
Route::group(array('prefix' => 'auth'), function() {
  # Login
  Route::get('signin', array('as' => 'signin', 'uses' => 'AuthController@signin'));
  Route::post('signin', 'AuthController@login');
  # Register
  Route::get('signup', array('as' => 'signup', 'uses' => 'AuthController@signup'));
  Route::post('signup', 'AuthController@store');
  # Account Activation
  Route::get('activate/{activationCode}', array('as' => 'activate', 'uses' => 'AuthController@activate'));
  # Forgot Password
  Route::get('forgot-password', array('as' => 'forgot-password', 'uses' => 'AuthController@forgotPassword'));
  Route::post('forgot-password', 'AuthController@sendForgotPassword');
  # Forgot Password Confirmation
  Route::get('forgot-password/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'AuthController@confirmForgotPassword'));
  Route::post('forgot-password/{passwordResetCode}', 'AuthController@chooseNewPassword');
  # Logout
  Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));
});

//geo data route
Route::group(array('prefix' => 'geo'), function() {
  Route::get('geo/{$city}/{$radius?}', array('as' => 'geo.city', 'uses' => 'GeolocController@getNearestCities'));

});


