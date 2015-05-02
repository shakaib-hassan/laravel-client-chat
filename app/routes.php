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

Route::get('/', function(){
	// $user = new User;
	// $res = $user->register_new_user(array("name" => "shakaib","email" => "shakaib@gmail.com"));
	return View::make('home');
    
    	
});


Route::get('create', function(){
	$user = new User;
	// $res = $user->register_new_user(array("name" => "shakaib","email" => "shakaib@gmail.com"));
	// return "This is home page";
	$user->name = "shakaib sibte hassan";
	$user->email = "shakaib@gmail.com";
	$user->username = "shakaib.hassan";
	$user->password = Hash::make("test");

	return $user->save();
    
            
             
});




Route::get('fb_login_callback', "HomeController@fb_login_callback");


Route::get("externalregister","HomeController@register");

Route::get("login","SessionsController@create");

Route::get("logout","SessionsController@destroy");

Route::get("register","SessionsController@register");

Route::get("user/home","SessionsController@home");


Route::post("sessions/create","SessionsController@create");



Route::resource('requests','FrequestsController');

Route::resource('friends','FriendsController');

Route::resource('sessions','SessionsController');