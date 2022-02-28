<?php

namespace Tests\Actions;

use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesConnectionTest extends TestCase
{
    public function test_connection_state()
    {
        $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');

        $this->assertEquals('Operational', $octoPrint->state());
    }

    public function test_connection_disconnect()
    {
        $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');

        $octoPrint->disconnect();

        $this->assertEquals("Closed", $octoPrint->state());
    }

    public function test_connection_connect()
    {
        $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');

        $octoPrint->connect();

        $this->assertTrue($octoPrint->state() === "Operational" || $octoPrint->state() === 'Detecting serial connection');
    }


}
