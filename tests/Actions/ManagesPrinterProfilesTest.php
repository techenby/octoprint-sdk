<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesPrinterProfilesTest extends TestCase
{
    public function test_getting_all_printer_profiles()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'printerprofiles', [])->andReturn(
            new Response(200, [], '{"profiles": {"_default": {"id": "_default","name": "Default","color": "default","model": "Generic RepRap Printer","default": true,"current": true,"resource": "http://example.com/api/printerprofiles/_default","volume": {"formFactor": "rectangular","origin": "lowerleft","width": 200,"depth": 200,"height": 200},"heatedBed": true,"heatedChamber": false,"axes": {"x": {"speed": 6000,"inverted": false},"y": {"speed": 6000,"inverted": false},"z": {"speed": 200,"inverted": false},"e": {"speed": 300,"inverted": false}},"extruder": {"count": 1,"offsets": [{"x": 0.0, "y": 0.0}]}},"my_profile": {"id": "my_profile","name": "My Profile","color": "default","model": "My Custom Printer","default": false,"current": false,"resource": "http://example.com/api/printerprofiles/my_profile","volume": {"formFactor": "rectangular","origin": "lowerleft","width": 200,"depth": 200,"height": 200},"heatedBed": true,"heatedChamber": true,"axes": {"x": {"speed": 6000,"inverted": false},"y": {"speed": 6000,"inverted": false},"z": {"speed": 200,"inverted": false},"e": {"speed": 300,"inverted": false}},"extruder": {"count": 1,"offsets": [{"x": 0.0, "y": 0.0}]}}}}')
        );

        $profiles = $octoPrint->profiles();

        $this->assertCount(2, $profiles);
    }

    public function test_recieving_printer_profile_by_id()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'printerprofiles/_default', [])->andReturn(
            new Response(200, [], '{"axes":{"e":{"inverted":false,"speed":300},"x":{"inverted":false,"speed":6000},"y":{"inverted":false,"speed":6000},"z":{"inverted":false,"speed":200}},"color":"default","current":true,"default":true,"extruder":{"count":1,"nozzleDiameter":0.4,"offsets":[[0.0,0.0]],"sharedNozzle":false},"heatedBed":true,"heatedChamber":false,"id":"_default","model":"Ender 3","name":"Eevee","resource":"http://eevee.local/api/printerprofiles/_default","volume":{"custom_box":false,"depth":220.0,"formFactor":"rectangular","height":250.0,"origin":"lowerleft","width":220.0}}')
        );

        $profile = $octoPrint->profile('_default');

        $this->assertEquals('Eevee', $profile->name);
    }

    public function test_creating_new_profile_based_on_default()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'printerprofiles', ['json' => ['profile' => ['id' => 'some_profile', 'name' => 'Some profile', 'model' => 'Some cool model']]])->andReturn(
            new Response(200, [], '{"profile": {"id": "some_profile","name": "Some profile","color": "default","model": "Some cool model","default": false,"current": false,"resource": "http://example.com/api/printerprofiles/some_profile","volume": {"formFactor": "rectangular","origin": "lowerleft","width": 200,"depth": 200,"height": 200},"heatedBed": true,"heatedChamber": false,"axes": {"x": {"speed": 6000,"inverted": false},"y": {"speed": 6000,"inverted": false},"z": {"speed": 200,"inverted": false},"e": {"speed": 300,"inverted": false}},"extruder": {"count": 1,"offsets": [{"x": 0.0, "y": 0.0}]}}}')
        );

        $profile = $octoPrint->createProfile(['id' => 'some_profile', 'name' => 'Some profile', 'model' => 'Some cool model']);

        $this->assertEquals('Some profile', $profile->name);
    }

    public function test_creating_new_profile_based_on_another()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $data = ['id' => 'some_other_profile', 'name' => 'Some other profile', 'heatedBed' => false, 'volume' => ['formFactor' => 'circular', 'origin' => 'cender', 'width' => 150, 'height' => 300], 'extruder' => ['count' => 2, 'offsets' => [['x' => 0.0, 'y' => '0.0'], ['x' => 21.6, 'y' => 0.0]]]];

        $http->shouldReceive('request')->once()->with('POST', 'printerprofiles', ['json' => ['profile' => $data, 'basedOn' => 'some_profile']])->andReturn(
            new Response(200, [], '{"profile": {"id": "some_other_profile","name": "Some other profile","color": "default","model": "Some cool model","default": false,"current": false,"resource": "http://example.com/api/printerprofiles/some_other_profile","volume": {"formFactor": "circular","origin": "center","width": 150,"depth": 150,"height": 300},"heatedBed": false,"heatedChamber": false,"axes": {"x": {"speed": 6000,"inverted": false},"y": {"speed": 6000,"inverted": false},"z": {"speed": 200,"inverted": false},"e": {"speed": 300,"inverted": false}},"extruder": {"count": 2,"offsets": [{"x": 0.0, "y": 0.0},{"x": 21.6, "y": 0.0}]}}}')
        );

        $profile = $octoPrint->createProfile($data, 'some_profile');

        $this->assertEquals('Some other profile', $profile->name);
    }

    public function test_updating_profile()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $data = ['name' => 'Some edited profile', 'volume' => ['depth' => 300]];

        $http->shouldReceive('request')->once()->with('POST', 'printerprofiles/some_profile', ['json' => ['profile' => $data]])->andReturn(
            new Response(200, [], '{"profile": {"id": "some_profile","name": "Some edited profile","color": "default","model": "Some cool model","default": false,"current": false,"resource": "http://example.com/api/printerprofiles/some_profile","volume": {"formFactor": "rectangular","origin": "lowerleft","width": 200,"depth": 300,"height": 200},"heatedBed": true,"heatedChamber": false,"axes": {"x": {"speed": 6000,"inverted": false},"y": {"speed": 6000,"inverted": false},"z": {"speed": 200,"inverted": false},"e": {"speed": 300,"inverted": false}},"extruder": {"count": 2,"offsets": [{"x": 0.0, "y": 0.0},{"x": 21.6, "y": 0.0}]}}}')
        );

        $profile = $octoPrint->updateProfile('some_profile', $data);

        $this->assertEquals('Some edited profile', $profile->name);
    }

    public function test_deleting_profile()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('DELETE', 'printerprofiles/some_profile', [])->andReturn(
            new Response(204, [])
        );

        $this->assertNull($octoPrint->deleteProfile('some_profile'));
    }
}
