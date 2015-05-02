<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    public function register_new_user_external_login($data) {

        dd($data);

        $this->name = $data['name'];
        $this->email = $data['email'];
        $password = 'test';
        $this->password = Hash::make($password);



        if ($this->save()) {

            Mail::send('emails.welcome', array('user' => $this->name, 'password' => $password), function($message) {
                $message->to($this->email, $this->name)->subject('Welcome to the learning laravel');
            });

            return "created";
        } else {
            return "already exist";
        }
    }

    public function register_new_user($data) {


        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->username = $data['username'];
        $this->password = Hash::make($data['password']);

        if ($this->save()) {

//			Mail::send('emails.welcome',array('user' => $this->name,'password' => $password),function($message){
//				 $message->to($this->email, $this->name)->subject('Welcome to the learning laravel');
//			});		
//			create a xmpp user
//		
            if (Demo::create_muc_user($data['username'], $data['username'])) {
                return "created";
            }
            return "Unable to create muc user";
        } else {
            return "already exist";
        }
    }

    public function request_sent() {

        if (Frequest::where('to_user', '=', $this->username)->where('from_user', '=', Auth::user()->username)->first()) {
            return false;
        }
        return true;
    }

    public function is_a_friend() {
        if (Friend::where('to_user', '=', $this->username)->where('from_user', '=', Auth::user()->username)->first() || Friend::where('from_user', '=', $this->username)->where('to_user', '=', Auth::user()->username)->first()) {
            return true;
        }
        return false;
    }

}

User::creating(function($post) {
    // check if the users already exist.

    $res = User::where('email', '=', $post->email)->first();


    if (Input::has("username")) {
        $user = User::where('username', '=', $post->username)->first();
    }

    if ($res || $user) {
        // echo "email exist";
        return false;
    }

    return true;
});
