<?php

class SessionsController extends BaseController {

    public function __construct() {
        $this->beforeFilter('guest', array('only' => array('create', 'register')));
        
        $this->beforeFilter('auth', array('only' => array('home')));

        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function create() {
        if (Request::isMethod('post')) {

            if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')))) {

                return Redirect::intended('/');
            }

            return View::make("user.login", array("message" => "Failed"));
        } else {
            return View::make("user.login");
        }
    }

    public function register() {

        return View::make("user.register");
    }

    public function store() {

        $user = new User;
        $res = $user->register_new_user(Input::all());
        return View::make("user.created")->with('message', $res);
    }

    public function destroy() {

        Auth::logout();
        return Redirect::intended("/");
    }

    public function home() {
        
        $users = User::all();
        return View::make("user.home",array('users' => $users));
        
    }
    

}
