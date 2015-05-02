<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Demo {

    public function mode_curl($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
    }

    public function query($type, $username, $password = null, $name = null, $email = null, $groups = null) {
        $url = Config::get('openfire.OPHOST') . ':' . Config::get('openfire.OPPORT')
                . '/plugins/userService/userservice?'
                . 'secret=' . Config::get('openfire.OPSECRET')
                . '&type=' . $type
                . '&username=' . $username
                . '&password=' . $password
                . '&name=' . $name
                . '&email=' . $email
                . '&groups=' . $groups;


        $result = $this->mode_curl($url);
           return $result;
    }

    public static function create_muc_user($username, $password) {

        $_this = new self;
        $response = $_this->query('add', $username, $password);

        $res = (simplexml_load_string($response));

        if ($res[0] == "ok") {
            return TRUE;
        }
        return FALSE;
    }

}
