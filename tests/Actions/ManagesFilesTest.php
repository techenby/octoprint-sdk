<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesFilesTest extends TestCase
{
    public function test_getting_all_files()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'files', ['query' => ['recursive' => true]])->andReturn(
            new Response(200, [], '{"files": [{"name": "whistle_v2.gcode","path": "whistle_v2.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 1468987,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/whistle_v2.gcode","download": "http://example.com/downloads/files/local/whistle_v2.gcode"},"gcodeAnalysis": {"estimatedPrintTime": 1188,"filament": {"length": 810,"volume": 5.36}},"print": {"failure": 4,"success": 23,"last": {"date": 1387144346,"success": true}}},{"name": "whistle_.gco","path": "whistle_.gco","type": "machinecode","typePath": ["machinecode", "gcode"],"origin": "sdcard","refs": {"resource": "http://example.com/api/files/sdcard/whistle_.gco"}},{"name": "folderA","path": "folderA","type": "folder","typePath": ["folder"],"children": [{"name": "test.gcode","path": "folderA/test.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 1234,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/folderA/test.gcode","download": "http://example.com/downloads/files/local/folderA/test.gcode"}},{"name": "subfolder","path": "folderA/subfolder","type": "folder","typePath": ["folder"],"children": [{"name": "test.gcode","path": "folderA/subfolder/test2.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 100,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/folderA/subfolder/test2.gcode","download": "http://example.com/downloads/files/local/folderA/subfolder/test2.gcode"}}],"size": 100,"refs": {"resource": "http://example.com/api/files/local/folderA/subfolder"}}],"size": 1334,"refs": {"resource": "http://example.com/api/files/local/folderA"}}],"free": "3.2GB"}')
        );

        $files = $octoPrint->files();

        $this->assertCount(3, $files);
    }

    public function test_getting_all_files_without_recursion()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'files', ['query' => ['recursive' => false]])->andReturn(
            new Response(200, [], '{"files": [{"name": "whistle_v2.gcode","path": "whistle_v2.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 1468987,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/whistle_v2.gcode","download": "http://example.com/downloads/files/local/whistle_v2.gcode"},"gcodeAnalysis": {"estimatedPrintTime": 1188,"filament": {"length": 810,"volume": 5.36}},"print": {"failure": 4,"success": 23,"last": {"date": 1387144346,"success": true}}},{"name": "whistle_.gco","path": "whistle_.gco","type": "machinecode","typePath": ["machinecode", "gcode"],"origin": "sdcard","refs": {"resource": "http://example.com/api/files/sdcard/whistle_.gco"}},{"name": "folderA","path": "folderA","type": "folder","typePath": ["folder"],"children": [{"name": "whistle_v2_copy.gcode","path": "whistle_v2_copy.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 1468987,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/folderA/whistle_v2_copy.gcode","download": "http://example.com/downloads/files/local/folderA/whistle_v2_copy.gcode"},"gcodeAnalysis": {"estimatedPrintTime": 1188,"filament": {"length": 810,"volume": 5.36}},"print": {"failure": 4,"success": 23,"last": {"date": 1387144346,"success": true}}}]}],"free": "3.2GB"}')
        );

        $files = $octoPrint->files(false);

        $this->assertCount(3, $files);
    }

    public function test_getting_specific_file()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'files/local/whistle_v2.gcode', [])->andReturn(
            new Response(200, [], '{"name": "whistle_v2.gcode","size": 1468987,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/whistle_v2.gcode","download": "http://example.com/downloads/files/local/whistle_v2.gcode"},"gcodeAnalysis": {"estimatedPrintTime": 1188,"filament": {"length": 810,"volume": 5.36}},"print": {"failure": 4,"success": 23,"last": {"date": 1387144346,"success": true}}}')
        );

        $file = $octoPrint->file('local', 'whistle_v2.gcode');

        $this->assertEquals('whistle_v2.gcode', $file->name);
    }
}
