<?php

namespace TechEnby\OctoPrint\Resources;

class User extends Resource
{
    /**
     * The name of the user.
     *
     * @var string
     */
    public $name;

    /**
     * The permissions of the user.
     *
     * @var string
     */
    public $permissions;

    /**
     * Last groups of user.
     *
     * @var string
     */
    public $groups;
}
