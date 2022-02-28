<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesCurrentUserTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_making_current_urser_request()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'currentuser', [])->andReturn(
            new Response(200, [], '{"name":"ngrok","permissions":["ADMIN","STATUS","CONNECTION","WEBCAM","SYSTEM","FILES_LIST","FILES_UPLOAD","FILES_DOWNLOAD","FILES_DELETE","FILES_SELECT","PRINT","GCODE_VIEWER","MONITOR_TERMINAL","CONTROL","SLICE","TIMELAPSE_LIST","TIMELAPSE_DOWNLOAD","TIMELAPSE_DELETE","TIMELAPSE_ADMIN","SETTINGS_READ","SETTINGS","PLUGIN_ACTION_COMMAND_NOTIFICATION_SHOW","PLUGIN_ACTION_COMMAND_NOTIFICATION_CLEAR","PLUGIN_ACTION_COMMAND_PROMPT_INTERACT","PLUGIN_ANNOUNCEMENTS_READ","PLUGIN_ANNOUNCEMENTS_MANAGE","PLUGIN_APPKEYS_ADMIN","PLUGIN_BACKUP_ACCESS","PLUGIN_FIRMWARE_CHECK_DISPLAY","PLUGIN_LOGGING_MANAGE","PLUGIN_NGROK_VIEW","PLUGIN_NGROK_CONTROL","PLUGIN_PI_SUPPORT_STATUS","PLUGIN_PLUGINMANAGER_MANAGE","PLUGIN_PLUGINMANAGER_INSTALL","PLUGIN_SOFTWAREUPDATE_CHECK","PLUGIN_SOFTWAREUPDATE_UPDATE","PLUGIN_SOFTWAREUPDATE_CONFIGURE"],"groups":["admins","users"]}')
        );

        $user = $octoPrint->currentUser();

        $this->assertEquals('ngrok', $user->name);
        $this->assertCount(38, $user->permissions);
        $this->assertCount(2, $user->groups);
    }
}
