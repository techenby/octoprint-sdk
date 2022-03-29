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

    public function test_getting_all_files_by_location()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'files/local', ['query' => ['recursive' => true]])->andReturn(
            new Response(200, [], '{"files": [{"name": "whistle_v2.gcode","path": "whistle_v2.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 1468987,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/whistle_v2.gcode","download": "http://example.com/downloads/files/local/whistle_v2.gcode"},"gcodeAnalysis": {"estimatedPrintTime": 1188,"filament": {"length": 810,"volume": 5.36}},"print": {"failure": 4,"success": 23,"last": {"date": 1387144346,"success": true}}},{"name": "whistle_.gco","path": "whistle_.gco","type": "machinecode","typePath": ["machinecode", "gcode"],"origin": "sdcard","refs": {"resource": "http://example.com/api/files/sdcard/whistle_.gco"}},{"name": "folderA","path": "folderA","type": "folder","typePath": ["folder"],"children": [{"name": "test.gcode","path": "folderA/test.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 1234,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/folderA/test.gcode","download": "http://example.com/downloads/files/local/folderA/test.gcode"}},{"name": "subfolder","path": "folderA/subfolder","type": "folder","typePath": ["folder"],"children": [{"name": "test.gcode","path": "folderA/subfolder/test2.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 100,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/folderA/subfolder/test2.gcode","download": "http://example.com/downloads/files/local/folderA/subfolder/test2.gcode"}}],"size": 100,"refs": {"resource": "http://example.com/api/files/local/folderA/subfolder"}}],"size": 1334,"refs": {"resource": "http://example.com/api/files/local/folderA"}}],"free": "3.2GB"}')
        );

        $files = $octoPrint->files(true, 'local');

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

    public function test_getting_all_files_without_recursion_by_location()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'files/local', ['query' => ['recursive' => false]])->andReturn(
            new Response(200, [], '{"files": [{"name": "whistle_v2.gcode","path": "whistle_v2.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 1468987,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/whistle_v2.gcode","download": "http://example.com/downloads/files/local/whistle_v2.gcode"},"gcodeAnalysis": {"estimatedPrintTime": 1188,"filament": {"length": 810,"volume": 5.36}},"print": {"failure": 4,"success": 23,"last": {"date": 1387144346,"success": true}}},{"name": "whistle_.gco","path": "whistle_.gco","type": "machinecode","typePath": ["machinecode", "gcode"],"origin": "sdcard","refs": {"resource": "http://example.com/api/files/sdcard/whistle_.gco"}},{"name": "folderA","path": "folderA","type": "folder","typePath": ["folder"],"children": [{"name": "test.gcode","path": "folderA/test.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 1234,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/folderA/test.gcode","download": "http://example.com/downloads/files/local/folderA/test.gcode"}},{"name": "subfolder","path": "folderA/subfolder","type": "folder","typePath": ["folder"],"children": [{"name": "test.gcode","path": "folderA/subfolder/test2.gcode","type": "machinecode","typePath": ["machinecode", "gcode"],"hash": "...","size": 100,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/folderA/subfolder/test2.gcode","download": "http://example.com/downloads/files/local/folderA/subfolder/test2.gcode"}}],"size": 100,"refs": {"resource": "http://example.com/api/files/local/folderA/subfolder"}}],"size": 1334,"refs": {"resource": "http://example.com/api/files/local/folderA"}}],"free": "3.2GB"}')
        );

        $files = $octoPrint->files(false, 'local');

        $this->assertCount(3, $files);
    }

    public function test_getting_specific_file()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'files/local/whistle_v2.gcode', [])->andReturn(
            new Response(200, [], '{"name": "whistle_v2.gcode","size": 1468987,"date": 1378847754,"origin": "local","refs": {"resource": "http://example.com/api/files/local/whistle_v2.gcode","download": "http://example.com/downloads/files/local/whistle_v2.gcode"},"gcodeAnalysis": {"estimatedPrintTime": 1188,"filament": {"length": 810,"volume": 5.36}},"print": {"failure": 4,"success": 23,"last": {"date": 1387144346,"success": true}}}')
        );

        $file = $octoPrint->file('local', 'whistle_v2.gcode');

        $this->assertEquals('whistle_v2.gcode', $file['name']);
    }

    public function test_uploading_file()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('post')->once()->with('files/local', ['multipart' => [
            ['name' => 'path', 'contents' => 'some_folder/subfolder/'],
            ['name' => 'file', 'filename' => 'whistle_v2.gcode', 'contents' => 'M109 TO S220.00000']
        ]])->andReturn(
            new Response(200, [], '{"done":true,"files":{"local":{"name":"whistle_v2.gcode","origin":"local","path":"some_folder/subfolder/whistle_v2.gcode","refs":{"download":"http://eevee.local/downloads/files/local/some_folder/subfolder/whistle_v2.gcode","resource":"http://eevee.local/api/files/local/some_folder/subfolder/whistle_v2.gcode"}}}}')
        );

        $this->assertTrue($octoPrint->uploadFile('local', 'some_folder/subfolder/whistle_v2.gcode', 'M109 TO S220.00000')['done']);
    }

    public function test_selecting_file()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'files/local/whistle_v2.gcode', ['json' => ['command' => 'select', 'print' => true]])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->selectFile('local', 'whistle_v2.gcode', true));
    }

    public function test_unselecting_file()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'files/local/whistle_v2.gcode', ['json' => ['command' => 'unselect']])->andReturn(
            new Response(204, [])
        );

        $this->assertEquals($octoPrint, $octoPrint->unselectFile('local', 'whistle_v2.gcode'));
    }

    public function test_slicing_file()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $data = ['slicer' => 'cura', 'gcode' => 'some_mode.first_try.gcode', 'printerProfile' => 'my_custom_reprap', 'profile' => 'high_quality', 'profile.infill' => 75, 'profile.fill_density' => 15, 'position' => ['x' => 100, 'y' => 100], 'print' => true];

        $http->shouldReceive('request')->once()->with('POST', 'files/local/some_folder/some_model.stl', ['json' => array_merge(['command' => 'slice'], $data)])->andReturn(
            new Response(202, [], '{"origin": "local","name": "some_model.first_try.gcode","path": "some_folder/some_model.first_try.gcode","refs": {"download": "http://example.com/downloads/files/local/some_folder/some_model.first_try.gcode","resource": "http://example.com/api/files/local/some_folder/some_model.first_try.gcode"}}')
        );

        $this->assertCount(4, $octoPrint->sliceFile('local', 'some_folder/some_model.stl', $data));
    }

    public function test_copying_file()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'files/local/some_folder/some_model.gcode', ['json' => ['command' => 'copy', 'destination' => 'some_other_folder/subfolder']])->andReturn(
            new Response(201, [], '{"origin": "local","name": "some_model.gcode","path": "some_other_folder/subfolder/some_model.gcode","refs": {"download": "http://example.com/downloads/files/local/some_other_folder/subfolder/some_model.gcode","resource": "http://example.com/api/files/local/some_other_folder/subfolder/some_model.gcode"}}')
        );

        $this->assertCount(4, $octoPrint->copyFile('local', 'some_folder/some_model.gcode', 'some_other_folder/subfolder'));
    }

    public function test_moving_file()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'files/local/some_folder/some_model.gcode', ['json' => ['command' => 'move', 'destination' => 'some_other_folder/subfolder']])->andReturn(
            new Response(201, [], '{"origin": "local","name": "and_a_subfolder","path": "some_other_folder/and_a_subfolder","refs": {"resource": "http://example.com/api/files/local/some_other_folder/and_a_subfolder"}}')
        );

        $this->assertCount(4, $octoPrint->moveFile('local', 'some_folder/some_model.gcode', 'some_other_folder/subfolder'));
    }

    public function test_deleting_file()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('DELETE', 'files/local/whistle_v2.gcode', [])->andReturn(
            new Response(204, [])
        );

        $this->assertNull($octoPrint->deleteFile('local', 'whistle_v2.gcode'));
    }
}
