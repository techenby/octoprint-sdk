<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesServerTest extends TestCase
{
    public function test_server()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'server', [])->andReturn(
            new Response(200, [], '{"version": "1.5.0","safemode": "incomplete_startup"}')
        );

        $server = $octoPrint->server();

        $this->assertEquals('1.5.0', $server->version);
        $this->assertEquals('incomplete_startup', $server->safemode);
    }
}
