<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\Connection;

trait ManagesConnection
{
    public function connection()
    {
        return new Connection($this->get('connection'));
    }

    public function state()
    {
        return $this->get('connection')['current']['state'];
    }

    public function connect()
    {
        return $this->post('connection', ['json' => ['command' => 'connect']]);
    }

    public function disconnect()
    {
        return $this->post('connection', ['json' => ['command' => 'disconnect']]);
    }
}
