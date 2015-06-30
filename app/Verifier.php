<?php namespace Muhit;

use Auth;

class Verifier {
    public function verify($email, $password)
    {
        $credentials = [
            'email'    => $email,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}
