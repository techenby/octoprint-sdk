<?php

namespace TechEnby\OctoPrint\Actions;

use TechEnby\OctoPrint\Resources\Version;

trait ManagesVersion
{
    public function version()
    {
        return new Version($this->get('version'));
    }
}
