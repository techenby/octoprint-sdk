<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesTimelapsesTest extends TestCase
{
    public function test_recieving_timelapses()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'timelapse', ['query' => ['unrendered' => false]])->andReturn(
            new Response(200, [], '{"config":{"fps":25,"interval":10,"postRoll":0,"type":"timed"},"enabled":true,"files":[{"bytes":6059241,"date":"2022-01-22 18:58","name":"CE3_clamp protector tri_20220122183722.mp4","size":"5.8MB","url":"/downloads/timelapse/CE3_clamp%20protector%20tri_20220122183722.mp4"},{"bytes":597178,"date":"2022-02-23 10:04","name":"CE3_SDD Boxes - full_20220223100158-fail.mp4","size":"583.2KB","url":"/downloads/timelapse/CE3_SDD%20Boxes%20-%20full_20220223100158-fail.mp4"}]}')
        );

        $timelapses = $octoPrint->timelapses();

        $this->assertCount(2, $timelapses);
    }

    public function test_recieving_timelapse_config()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'timelapse', [])->andReturn(
            new Response(200, [], '{"config":{"fps":25,"interval":10,"postRoll":0,"type":"timed"},"enabled":true,"files":[{"bytes":6059241,"date":"2022-01-22 18:58","name":"CE3_clamp protector tri_20220122183722.mp4","size":"5.8MB","url":"/downloads/timelapse/CE3_clamp%20protector%20tri_20220122183722.mp4"},{"bytes":597178,"date":"2022-02-23 10:04","name":"CE3_SDD Boxes - full_20220223100158-fail.mp4","size":"583.2KB","url":"/downloads/timelapse/CE3_SDD%20Boxes%20-%20full_20220223100158-fail.mp4"}]}')
        );

        $config = $octoPrint->timelapseConfig();

        $this->assertCount(4, $config);
    }

    public function test_deleting_timelapse()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('DELETE', 'timelapse/CE3_SDD Boxes - full_20220223100158-fail.mp4', [])->andReturn(
            new Response(200, [], '{"config":{"fps":25,"interval":10,"postRoll":0,"type":"timed"},"enabled":true,"files":[{"bytes":6059241,"date":"2022-01-22 18:58","name":"CE3_clamp protector tri_20220122183722.mp4","size":"5.8MB","url":"/downloads/timelapse/CE3_clamp%20protector%20tri_20220122183722.mp4"}]}')
        );

        $timelapses = $octoPrint->deleteTimelapse('CE3_SDD Boxes - full_20220223100158-fail.mp4');

        $this->assertCount(1, $timelapses);
    }

    public function test_rendering_timelapse()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'timelapse/unrendered/CE3_SDD Boxes - full_20220223100158-fail', [])->andReturn(
            new Response(200, [], '{"config":{"fps":25,"interval":10,"postRoll":0,"type":"timed"},"enabled":true,"files":[{"bytes":6059241,"date":"2022-01-22 18:58","name":"CE3_clamp protector tri_20220122183722.mp4","size":"5.8MB","url":"/downloads/timelapse/CE3_clamp%20protector%20tri_20220122183722.mp4"},{"bytes":597178,"date":"2022-02-23 10:04","name":"CE3_SDD Boxes - full_20220223100158-fail.mp4","size":"583.2KB","url":"/downloads/timelapse/CE3_SDD%20Boxes%20-%20full_20220223100158-fail.mp4"}]}')
        );

        $timelapses = $octoPrint->renderTimelapse('CE3_SDD Boxes - full_20220223100158-fail');

        $this->assertCount(2, $timelapses);
    }

    public function test_deleting_unrendered_timelapse()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('DELETE', 'timelapse/unrendered/CE3_SDD Boxes - full_20220223100158-fail', [])->andReturn(
            new Response(200, [], '{"config":{"fps":25,"interval":10,"postRoll":0,"type":"timed"},"enabled":true,"unrendered":[{"bytes":6059241,"date":"2022-01-22 18:58","name":"CE3_clamp protector tri_20220122183722.mp4","size":"5.8MB","url":"/downloads/timelapse/CE3_clamp%20protector%20tri_20220122183722.mp4"}]}')
        );

        $timelapses = $octoPrint->deleteTimelapse('CE3_SDD Boxes - full_20220223100158-fail', true);

        $this->assertCount(1, $timelapses);
    }

    public function test_changing_timelapse_settings()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'timelapse', ['json' => ['type' => 'off']])->andReturn(
            new Response(200, [], '{"config":{"fps":25,"interval":10,"postRoll":0,"type":"timed"},"enabled":false,"files":[{"bytes":6059241,"date":"2022-01-22 18:58","name":"CE3_clamp protector tri_20220122183722.mp4","size":"5.8MB","url":"/downloads/timelapse/CE3_clamp%20protector%20tri_20220122183722.mp4"}]}')
        );

        $config = $octoPrint->updateTimelapseSettings(['type' => 'off']);

        $this->assertCount(4, $config);
    }
}
