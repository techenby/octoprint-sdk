<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesPrinterTest extends TestCase
{
    public function test_getting_current_printer_state()
    {
        // $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'printer', [])->andReturn(
            new Response(200, [], '{"sd":{"ready":false},"state":{"error":"","flags":{"cancelling":false,"closedOrError":false,"error":false,"finishing":false,"operational":true,"paused":false,"pausing":false,"printing":false,"ready":true,"resuming":false,"sdReady":false},"text":"Operational"},"temperature":{"bed":{"actual":25.62,"offset":0,"target":0.0},"tool0":{"actual":25.45,"offset":0,"target":0.0}}}')
        );

        $printer = $octoPrint->printer();

        $this->assertEquals(25.62, $printer->temperature['bed']['actual']);
    }
}
