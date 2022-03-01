<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesSettingsTest extends TestCase
{
    public function test_retrieving_settings()
    {
        // $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'settings', [])->andReturn(
            new Response(200, [], '{"api": {"allowCrossOrigin": false,"key": "123123123123123123"},"appearance": {"closeModalsWithClick": true,"color": "default","colorIcon": true,"colorTransparent": false,"defaultLanguage": "_default","fuzzyTimes": true,"name": "Eevee","showFahrenheitAlso": false,"showInternalFilename": true},"feature": {"autoUppercaseBlacklist": ["M117", "M118"],"g90InfluencesExtruder": false,"keyboardControl": true,"modelSizeDetection": true,"pollWatched": false,"printCancelConfirmation": true,"printStartConfirmation": false,"sdSupport": true,"temperatureGraph": true,"uploadOverwriteConfirmation": true},"gcodeAnalysis": {"bedZ": 0,"runAt": "idle"},"printer": {"defaultExtrusionLength": 5},"webcam": {"bitrate": "10000k","cacheBuster": false,"ffmpegCommandline": "{ffmpeg} -r {fps} -i \"{input}\" -vcodec {videocodec} -threads {threads} -b:v {bitrate} -f {containerformat} -y {filters} \"{output}\"","ffmpegPath": "/usr/bin/ffmpeg","ffmpegThreads": 1,"ffmpegVideoCodec": "libx264","flipH": false,"flipV": false,"rotate90": false,"snapshotSslValidation": true,"snapshotTimeout": 5,"snapshotUrl": "http://127.0.0.1:8080/?action=snapshot","streamRatio": "16:9","streamTimeout": 5,"streamUrl": "/webcam/?action=stream","timelapseEnabled": true,"watermark": true,"webcamEnabled": true}}')
        );

        $settings = $octoPrint->settings();

        $this->assertCount(6, $settings);
    }

    public function test_updating_settings()
    {
        // $octoPrint = new OctoPrint('http://eevee.local', 'D868EB9BF75B48E88BCDF73FCD9DCAA9');
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'settings', ['json' => ['appearance' => ['color' => 'black']]])->andReturn(
            new Response(200, [], '{"api": {"allowCrossOrigin": false,"key": "123123123123123123"},"appearance": {"closeModalsWithClick": true,"color": "black","colorIcon": true,"colorTransparent": false,"defaultLanguage": "_default","fuzzyTimes": true,"name": "Eevee","showFahrenheitAlso": false,"showInternalFilename": true},"feature": {"autoUppercaseBlacklist": ["M117", "M118"],"g90InfluencesExtruder": false,"keyboardControl": true,"modelSizeDetection": true,"pollWatched": false,"printCancelConfirmation": true,"printStartConfirmation": false,"sdSupport": true,"temperatureGraph": true,"uploadOverwriteConfirmation": true},"gcodeAnalysis": {"bedZ": 0,"runAt": "idle"},"printer": {"defaultExtrusionLength": 5},"webcam": {"bitrate": "10000k","cacheBuster": false,"ffmpegCommandline": "{ffmpeg} -r {fps} -i \"{input}\" -vcodec {videocodec} -threads {threads} -b:v {bitrate} -f {containerformat} -y {filters} \"{output}\"","ffmpegPath": "/usr/bin/ffmpeg","ffmpegThreads": 1,"ffmpegVideoCodec": "libx264","flipH": false,"flipV": false,"rotate90": false,"snapshotSslValidation": true,"snapshotTimeout": 5,"snapshotUrl": "http://127.0.0.1:8080/?action=snapshot","streamRatio": "16:9","streamTimeout": 5,"streamUrl": "/webcam/?action=stream","timelapseEnabled": true,"watermark": true,"webcamEnabled": true}}')
        );

        $settings = $octoPrint->updateSettings(['appearance' => ['color' => 'black']]);

        $this->assertEquals('black', $settings['appearance']['color']);
    }

    public function test_regenerating_the_system_api_key()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'settings/apikey', [])->andReturn(
            new Response(200, [], '{"apikey": "123123123123"}')
        );

        $newKey = $octoPrint->regenerateApiKey();

        $this->assertEquals('123123123123',$newKey);
    }
}
