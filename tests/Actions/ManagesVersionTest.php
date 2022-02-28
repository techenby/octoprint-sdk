<?php

namespace Tests\Actions;

use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesVersionTest extends TestCase
{
    public function test_version()
    {
        $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');

        $version = $octoPrint->version();

        $this->assertEquals('0.1', $version->api);
        $this->assertEquals('1.7.3', $version->server);
        $this->assertEquals('OctoPrint 1.7.3', $version->text);
    }

}
