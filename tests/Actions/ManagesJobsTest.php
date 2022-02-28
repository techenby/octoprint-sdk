<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesJobsTest extends TestCase
{
    public function test_getting_current_job()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'job', [])->andReturn(
            new Response(200, [], '{"job": {"file": {"name": "whistle_v2.gcode","origin": "local","size": 1468987,"date": 1378847754},"estimatedPrintTime": 8811,"filament": {"tool0": {"length": 810,"volume": 5.36}}},"progress": {"completion": 0.2298468264184775,"filepos": 337942,"printTime": 276,"printTimeLeft": 912},"state": "Printing"}')
        );

        $job = $octoPrint->job();

        $this->assertEquals('whistle_v2.gcode', $job->job['file']['name']);
        $this->assertEquals('Printing', $job->state);
    }

    public function test_start_job()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'job', [
            'json' => ['command' => 'start']
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals('', $octoPrint->start());
    }

    public function test_cancelling_job()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'job', [
            'json' => ['command' => 'cancel']
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals('', $octoPrint->cancel());
    }

    public function test_restarting_job()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'job', [
            'json' => ['command' => 'restart']
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals('', $octoPrint->restart());
    }

    public function test_pausing_job()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'job', [
            'json' => ['command' => 'pause', 'action' => 'toggle']
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals('', $octoPrint->pause());
    }
}
