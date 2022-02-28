<?php

namespace Tests\Actions;

use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesServerTest extends TestCase
{
    public function test_server()
    {
        $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');

        $server = $octoPrint->server();

        $this->assertEquals('1.7.3', $server->version);
        $this->assertEquals(null, $server->safemode);
    }

}
