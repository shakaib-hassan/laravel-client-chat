<?php

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\Entities\AccessToken;
use Facebook\FacebookRequest;
use Facebook\GraphUser;

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}


	public function register(){

		  @session_start(); // Add this to initialize session

		  FacebookSession::setDefaultApplication(Config::get('facebook.appId'), Config::get('facebook.secret'));

		  $helper = new FacebookRedirectLoginHelper(URL::to("fb_login_callback"));

		  return View::make('create_user')->with('url', $helper->getLoginUrl(array('scope' => 'email')));


		}


		public function fb_login_callback(){

			@session_start();
    		
			FacebookSession::setDefaultApplication(Config::get('facebook.appId'), Config::get('facebook.secret'));

			$helper = new FacebookRedirectLoginHelper(URL::to("fb_login_callback"));
			
			$session = null;

			try {
				$session = $helper->getSessionFromRedirect();
			} catch(FacebookRequestException $ex) {
        // When Facebook returns an error
			} catch(\Exception $ex) {
        // When validation fails or other local issues
			}
			
			// echo "<pre>";
			if ($session){
				$accessToken = $session->getAccessToken();
				$longLivedAccessToken = $accessToken->extend();


				$request = new FacebookRequest($session, 'GET', '/me');
				$response = $request->execute();
				$graphObject = $response->getGraphObject()->asArray();

                                
				$user  = new User;
				$res = $user->register_new_user($graphObject);
				return View::make("user.created")->with('message',$res);
			}
		}

	}
