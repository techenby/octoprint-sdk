<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesSlicingTest extends TestCase
{
    public function test_recieving_slicing_profiles()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'slicing', [])->andReturn(
            new Response(200, [], '{"curalegacy": {"key": "curalegacy","displayName": "Cura Legacy","default": true,"profiles": {"high_quality": {"key": "high_quality","displayName": "High Quality","default": false,"resource": "http://example.com/api/slicing/curalegacy/profiles/high_quality"},"medium_quality": {"key": "medium_quality","displayName": "Medium Quality","default": true,"resource": "http://example.com/api/slicing/curalegacy/profiles/medium_quality"}}}}')
        );

        $slicers = $octoPrint->slicers();

        $this->assertCount(1, $slicers);
        $this->assertCount(2, $slicers['curalegacy']['profiles']);
    }

    public function test_recieving_profiles_by_slicer()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'slicing/curalegacy/profiles', [])->andReturn(
            new Response(200, [], '{"high_quality": {"key": "high_quality","displayName": "High Quality","default": false,"resource": "http://example.com/api/slicing/curalegacy/profiles/high_quality"},"medium_quality": {"key": "medium_quality","displayName": "Medium Quality","default": true,"resource": "http://example.com/api/slicing/curalegacy/profiles/medium_quality"}}')
        );

        $profiles = $octoPrint->slicerProfiles('curalegacy');

        $this->assertCount(2, $profiles);
    }

    public function test_recieving_profile_by_slicer()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'slicing/curalegacy/profiles/high_quality', [])->andReturn(
            new Response(200, [], '{"displayName": "Just a test","description": "This is just a test","resource": "http://example.com/api/slicing/curalegacy/profiles/quick_test","data": {"bottom_layer_speed": 20.0,"bottom_thickness": 0.3,"brim_line_count": 20,"cool_head_lift": false,"cool_min_feedrate": 10.0,"cool_min_layer_time": 5.0}}')
        );

        $profile = $octoPrint->slicerProfile('curalegacy', 'high_quality');

        $this->assertEquals('Just a test', $profile['displayName']);
    }

    public function test_creating_profile()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $data = ['displayName' => 'Just a test', 'description' => "This is just a test", "data" => ['layer_height' => 0.2, 'skirt_line_count' => 3]];

        $http->shouldReceive('request')->once()->with('PUT', 'slicing/curalegacy/profiles/quick_test', ['json' => $data])->andReturn(
            new Response(200, [], '{"displayName": "Just a test","description": "This is just a test to show how to create a curalegacy profile with a different layer height and skirt count","resource": "http://example.com/api/slicing/curalegacy/profiles/quick_test"}')
        );

        $profile = $octoPrint->createSlicerProfile('curalegacy', 'quick_test', $data);

        $this->assertEquals('Just a test', $profile['displayName']);
    }

    public function test_updating_profile()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $data = ['displayName' => 'Just a test', 'description' => "This is just a test", "data" => ['layer_height' => 0.2, 'skirt_line_count' => 3]];

        $http->shouldReceive('request')->once()->with('PATCH', 'slicing/curalegacy/profiles/quick_test', ['json' => $data])->andReturn(
            new Response(200, [], '{"displayName": "Just a test","description": "This is just a test to show how to create a curalegacy profile with a different layer height and skirt count","resource": "http://example.com/api/slicing/curalegacy/profiles/quick_test"}')
        );

        $profile = $octoPrint->updateSlicerProfile('curalegacy', 'quick_test', $data);

        $this->assertEquals('Just a test', $profile['displayName']);
    }

    public function test_deleting_profile()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('DELETE', 'slicing/curalegacy/profiles/quick_test', [])->andReturn(
            new Response(204, [])
        );

        $octoPrint->deleteSlicerProfile('curalegacy', 'quick_test');

        $this->assertNull($octoPrint->deleteSlicerProfile('curalegacy', 'quick_test'));
    }
}
