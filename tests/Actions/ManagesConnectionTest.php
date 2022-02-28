<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesConnectionTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_connection()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'connection', [])->andReturn(
            new Response(200, [], '{"current": {"state": "Operational","port": "/dev/ttyACM0","baudrate": 250000,"printerProfile": "_default"},"options": {"ports": ["/dev/ttyACM0", "VIRTUAL"],"baudrates": [250000, 230400, 115200, 57600, 38400, 19200, 9600],"printerProfiles": [{"name": "Default", "id": "_default"}],"portPreference": "/dev/ttyACM0","baudratePreference": 250000,"printerProfilePreference": "_default","autoconnect": true}}')
        );

        $connection = $octoPrint->connection();
        $this->assertEquals('Operational', $connection->current['state']);
        $this->assertCount(7, $connection->options['baudrates']);
    }

    public function test_connection_state()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'connection', [])->andReturn(
            new Response(200, [], '{"current": {"state": "Operational","port": "/dev/ttyACM0","baudrate": 250000,"printerProfile": "_default"},"options": {"ports": ["/dev/ttyACM0", "VIRTUAL"],"baudrates": [250000, 230400, 115200, 57600, 38400, 19200, 9600],"printerProfiles": [{"name": "Default", "id": "_default"}],"portPreference": "/dev/ttyACM0","baudratePreference": 250000,"printerProfilePreference": "_default","autoconnect": true}}')
        );

        $this->assertEquals('Operational', $octoPrint->state());
    }

    public function test_connection_disconnect()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'connection', [
            'json' => ['command' => 'disconnect']
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals('', $octoPrint->disconnect());
    }

    public function test_connection_connect()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'connection', [
            'json' => ['command' => 'connect']
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals('', $octoPrint->connect());
    }


}
