<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesVersionTest extends TestCase
{
    public function test_version()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'version', [])->andReturn(
            new Response(200, [], '{"api": "0.1","server": "1.3.10","text": "OctoPrint 1.3.10"}')
        );

        $server = $octoPrint->version();

        $this->assertEquals('0.1', $server->api);
        $this->assertEquals('1.3.10', $server->server);
        $this->assertEquals('OctoPrint 1.3.10', $server->text);
    }

    // public function test_version()
    // {
    //     $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');

    //     $version = $octoPrint->version();

    //     $this->assertEquals('0.1', $version->api);
    //     $this->assertEquals('1.7.3', $version->server);
    //     $this->assertEquals('OctoPrint 1.7.3', $version->text);
    // }

}
