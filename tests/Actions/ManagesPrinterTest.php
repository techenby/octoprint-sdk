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

        $http->shouldReceive('request')->once()->with('POST', 'printer/printhead', [
            'json' => ['command' => 'jog', 'x' => 5, 'y' => 0, 'z' => 0, 'absolute' => true]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->jog(5, 0, 0, true));
    }

    public function test_homeing_print_head()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/printhead', [
            'json' => ['command' => 'home', 'axes' => ['x', 'y', 'z']]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->home(['x', 'y', 'z']));
    }

    public function test_changing_feedrate()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/printhead', [
            'json' => ['command' => 'feedrate', 'factor' => 20]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->feedrate(20));
    }

    public function test_targeting_tool_temperatures()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/tool', [
            'json' => ['command' => 'target', 'targets' => ['tool0' => 200, 'tool1' => 210]]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->targetToolTemps(['tool0' => 200, 'tool1' => 210]));
    }

    public function test_offsetting_tool_temperatures()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/tool', [
            'json' => ['command' => 'offset', 'offsets' => ['tool0' => 10, 'tool1' => -5]]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->offsetToolTemps(['tool0' => 10, 'tool1' => -5]));
    }

    public function test_selecting_tool()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/tool', [
            'json' => ['command' => 'select', 'tool' => 'tool1']
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->selectTool('tool1'));
    }

    public function test_extruding_tool()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/tool', [
            'json' => ['command' => 'extrude', 'amount' => 100]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->extrude(100));
    }

    public function test_retracting_tool()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/tool', [
            'json' => ['command' => 'extrude', 'amount' => -3]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->retract(3));
    }

    public function test_flowrate_tool()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/tool', [
            'json' => ['command' => 'flowrate', 'factor' => 95]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->flowrate(95));
    }

    public function test_current_tool_state()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'printer/tool', [])->andReturn(
            new Response(200, [], '{"tool0": {"actual": 214.8821,"target": 220.0,"offset": 0},"tool1": {"actual": 25.3,"target": null,"offset": 0}}')
        );

        $tools = $octoPrint->tool();

        $this->assertCount(2, $tools);
    }

    public function test_targeting_bed_temperatures()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/bed', [
            'json' => ['command' => 'target', 'target' => 60]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->targetBedTemp(60));
    }

    public function test_offsetting_bed_temperatures()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/bed', [
            'json' => ['command' => 'offset', 'offset' => -5]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->offsetBedTemp(-5));
    }

    public function test_current_bed_state()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'printer/bed', [])->andReturn(
            new Response(200, [], '{"bed": {"actual": 50.221,"target":70.0,"offset":5}}')
        );

        $bed = $octoPrint->bed();

        $this->assertEquals(50.221, $bed['actual']);
    }

    public function test_targeting_chamber_temperatures()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/chamber', [
            'json' => ['command' => 'target', 'target' => 60]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->targetChamberTemp(60));
    }

    public function test_offsetting_chamber_temperatures()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/chamber', [
            'json' => ['command' => 'offset', 'offset' => -5]
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->offsetChamberTemp(-5));
    }

    public function test_current_chamber_state()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'printer/chamber', [])->andReturn(
            new Response(200, [], '{"chamber": {"actual": 50.221,"target":70.0,"offset":5}}')
        );

        $chamber = $octoPrint->chamber();

        $this->assertEquals(50.221, $chamber['actual']);
    }

    public function test_initializing_sd_card()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/sd', [
            'json' => ['command' => 'init']
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->initSD());
    }

    public function test_refreshing_sd_card()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/sd', [
            'json' => ['command' => 'refresh']
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->refreshSD());
    }

    public function test_releasing_sd_card()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printer/sd', [
            'json' => ['command' => 'release']
        ])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->releaseSD());
    }

    public function test_current_sd_state()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'printer/sd', [])->andReturn(
            new Response(200, [], '{"ready": true}')
        );

        $sd = $octoPrint->sd();

        $this->assertEquals(true, $sd['ready']);
    }
}
