<?php

namespace Tests\Actions;

use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesCurrentUserTest extends TestCase
{
    public function test_making_current_urser_request()
    {
        $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');

        $this->assertEquals('ngrok', $octoPrint->currentUser()->name);
    }
}
