<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\User;

trait ManagesAuthentication
{
    public function login()
    {
        return new User($this->post('login', ['json' => ['passive' => true]]));
    }

    public function currentUser()
    {
        return new User($this->get('currentuser'));
    }
}
