<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\Server;

trait ManagesServer
{
    public function server()
    {
        return new Server($this->get('server'));
    }
}
