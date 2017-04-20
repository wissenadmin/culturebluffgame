<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
  
    return view('index');
});


 
//    return view('jignesh');


Route::get('about', function () {
    return view('about');
});
 
Route::get('contactus', function () {
    return view('contactus');
});

Route::get('faq', function () {
    return view('faq');
});
/*Route::post('request-trial', function () {
    return view('request_trial');
});*/
Route::get('purchase-game', function () {
    return view('purchase_game');
});

Route::get('cronjob','Cronjob@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'HomeController@confirm'
]);

Route::any('register/purchase/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'HomeController@purchase'
]);

Route::get('payment-successful','HomeController@payment_successful');

Route::get('check-trial','HomeController@trailMail');

Route::get('payment-cancelled','HomeController@payment_cancelled');
Route::get('file-write','HomeController@file_write');
Route::get('notify','HomeController@notify');
Route::post('notify','HomeController@notify');
//Route::get('checkMailTemplates','HomeController@checkMailTemplates');
Route::get('checkMailTemplates','HomeController@checkMailTemplates');

Route::any('contactmail', 'HomeController@contactmail');
Route::any('pdf', 'HomeController@pdf');
@ # front user
Route::any('request-trial', 'HomeController@request_trial');
Route::any('purchase-game', 'HomeController@purchase_game');
Route::post('request-trial', 'HomeController@request_trial');
Route::post('getprice', 'HomeController@getprice');
Route::get('login', 'HomeController@frontlogin');
Route::post('login', 'HomeController@checkfrontlogin');
Route::get('frontlogout', 'HomeController@frontlogout');
Route::get('resetpassword', 'HomeController@resetpassword');
Route::get('home', function(){ 
  return redirect('front/home');
  });

Route::group(['middleware' => ['front'] ,'namespace' => 'front','prefix' => 'front'] ,function () {
   //$userData = Auth::user();
   //prd(Auth::user()); 
  Route::any('change-userpassword/{id}','HomeController@change_password');
   Route::get('', 'HomeController@index');
   Route::get('/', 'HomeController@index');
   Route::get('home', 'HomeController@index');
   Route::get('profile', 'HomeController@profile');
   Route::post('profile', 'HomeController@profile');


   Route::get('users', 'Users@index');
   Route::get('/jignesh', 'Users@jignesh');
   Route::get('users/add', 'Users@create');
   Route::post('users/add', 'Users@create');
   Route::get('users/view/{id}', 'Users@show');
   Route::get('users/edit/{id}', 'Users@edit');
   Route::post('users/edit/{id}', 'Users@edit');
   Route::get('users/delete/{id}', 'Users@destroy');
   Route::get('users/status/{id}', 'Users@status');
   Route::get('game-activity', 'HomeController@gameactivity');
   Route::get('reset-password', 'HomeController@resetpassword');
   Route::post('reset-password', 'HomeController@resetpassword');
   Route::get('game/{id}', 'HomeController@game');
   Route::any('buy-games', 'HomeController@buy_games');
 });



@ # admin function starts 
Route::get('admin/login', 'HomeController@login');
Route::post('admin/login', 'HomeController@checklogin');
Route::get('logout', 'HomeController@logout');

Route::group(['middleware' => ['auth', 'admin'] ,'namespace' => 'admin','prefix' => 'admin'] ,function () {

   Route::get('', 'Game@index');
   Route::get('/', 'Game@index');
   Route::get('profile', 'HomeController@profile');
   Route::post('profile', 'HomeController@profile');
   //games
   Route::get('games', 'Game@index');
   Route::get('games/add', 'Game@create');
   Route::post('games/add', 'Game@create');
   Route::get('games/edit/{id}', 'Game@edit');
   Route::post('games/edit/{id}', 'Game@edit');
   Route::get('games/delete/{id}', 'Game@destroy');
   Route::get('games/status/{id}', 'Game@status');
   Route::post('checktrial', 'Game@checktrial');
   
   

   //Users
   Route::get('users', 'Users@index');
   Route::get('super-trial', 'Users@superTrial');
   Route::get('add-super-trial', 'Users@createSuperTrial');
   Route::post('add-super-trial', 'Users@createSuperTrial');
   Route::get('users/view/{id}', 'Users@show');
   Route::get('licences-view/{id}', 'Users@show');
   Route::get('users/edit/{id}', 'Users@edit');
   Route::post('users/edit/{id}', 'Users@edit');
   Route::get('users/delete/{id}', 'Users@destroy');
   Route::get('users/status/{id}', 'Users@status');

   //Licences
   Route::get('licences', 'Licences@index');
   Route::get('licences/add', 'Licences@create');
   Route::post('licences/add', 'Licences@create');
   Route::get('licences/edit/{id}', 'Licences@edit');
   Route::post('licences/edit/{id}', 'Licences@edit');
   Route::get('licences/delete/{id}', 'Licences@destroy');
   Route::get('licences/status/{id}', 'Licences@status');

   //Static page
   Route::get('static-page', 'Static_page@index');
   Route::get('static-page/add', 'Static_page@create');
   Route::post('static-page/add', 'Static_page@create');
   Route::get('static-page/edit/{id}', 'Static_page@edit');
   Route::post('static-page/edit/{id}', 'Static_page@edit');
   Route::get('static-page/delete/{id}', 'Static_page@destroy');
   Route::get('static-page/status/{id}', 'Static_page@status');

   //licences-report
   Route::get('licences-report', 'Licences@report');
   Route::any('licences/manual-generation', 'Licences@manual_generation');
   Route::any('licences/manual-generation-admin/{flag}', 'Licences@manual_generation_admin');
   //manual-generation-admin
});

Route::get('/queue', function() {
    Cache::flush();

    $exitCode = Artisan::call('queue:work');
    // return what you want
});


