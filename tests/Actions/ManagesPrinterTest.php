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

    public function test_jogging_print_head()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer', [
            'json' => ['command' => 'jog', 'x' => 5, 'y' => 0, 'z' => 0, 'absolute' => true]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->jog(5, 0, 0, true));
    }

    public function test_homeing_print_head()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer', [
            'json' => ['command' => 'home', 'axes' => ['x', 'y', 'z']]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->home(['x', 'y', 'z']));
    }

    public function test_changing_feedrate()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer', [
            'json' => ['command' => 'feedrate', 'factor' => 20]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->feedrate(20));
    }
}
