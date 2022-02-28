<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\User;

trait ManagesConnection
{
    public function connection()
    {
        return $this->get('connection');
    }

    public function state()
    {
        return $this->get('connection')['current']['state'];
    }

    public function connect()
    {
        return $this->post('connection', ['command' => 'connect']);
    }

    public function disconnect()
    {
        return $this->post('connection', ['command' => 'disconnect']);
    }
}
