<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\User;

trait ManagesCurrentUser
{
    /**
     * Get the current user.
     *
     * @return \TechEnby\OctoPrint\Resources\User[]
     */
    public function currentUser()
    {
        return new User($this->get('currentuser'));
    }
}
