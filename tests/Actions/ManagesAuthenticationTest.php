<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesAuthenticationTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_logging_in()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'login', ['json' => ['passive' => true]])->andReturn(
            new Response(200, [], '{"_is_external_client":false,"_login_mechanism":"apikey","active":true,"admin":true,"apikey":null,"groups":["admins","users"],"name":"ngrok","needs":{"group":["users","admins"],"role":["plugin_action_command_notification_show","timelapse_delete","files_select","plugin_firmware_check_display","files_delete","plugin_softwareupdate_check","files_download","files_upload","timelapse_admin","print","system","timelapse_list","plugin_ngrok_display","gcodeviewer","plugin_pi_support_check","plugin_pluginmanager_install","monitor_terminal","plugin_announcements_read","plugin_appkeys_admin","plugin_ngrok_manage","control","plugin_logging_manage","admin","settings_read","plugin_announcements_manage","files_list","status","plugin_softwareupdate_configure","settings","plugin_backup_access","plugin_pluginmanager_manage","plugin_softwareupdate_update","slice","connection","plugin_action_command_notification_clear","timelapse_download","plugin_action_command_prompt_interact","webcam"]},"permissions":[],"roles":["user","admin"],"session":"40AE9BB78F7447EAB506049B5F3CFA36","settings":{},"user":true}')
        );

        $user = $octoPrint->login();

        $this->assertEquals('ngrok', $user->name);
        $this->assertCount(2, $user->groups);
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
