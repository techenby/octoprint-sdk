<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesSystemTest extends TestCase
{
    public function test_recieving_system_commands()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'system/commands', [])->andReturn(
            new Response(200, [], '{"core": [{"action": "shutdown","name": "Shutdown","source": "core","resource": "http://example.com/api/system/commands/core/shutdown"},{"action": "reboot","name": "Reboot","source": "core","resource": "http://example.com/api/system/commands/core/reboot"},{"action": "restart","name": "Restart OctoPrint","source": "core","resource": "http://example.com/api/system/commands/core/restart"}],"custom": []}')
        );

        $sources = $octoPrint->systemCommands();

        $this->assertCount(2, $sources);
        $this->assertCount(3, $sources['core']);
    }

    public function test_recieving_system_commands_from_source()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'system/commands/core', [])->andReturn(
            new Response(200, [], '[{"action": "shutdown","name": "Shutdown","source": "core","resource": "http://example.com/api/system/commands/core/shutdown"},{"action": "reboot","name": "Reboot","source": "core","resource": "http://example.com/api/system/commands/core/reboot"},{"action": "restart","name": "Restart OctoPrint","source": "core","resource": "http://example.com/api/system/commands/core/restart"}]')
        );

        $commands = $octoPrint->systemCommand('core');

        $this->assertCount(3, $commands);
    }

    public function test_running_a_system_command()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'system/commands/core/restart', [])->andReturn(
            new Response(204, [])
        );

        $this->assertNull($octoPrint->runSystemCommand('core', 'restart'));
    }
}
