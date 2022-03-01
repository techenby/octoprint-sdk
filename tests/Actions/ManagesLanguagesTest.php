<?php

namespace Tests\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use TechEnby\OctoPrint\OctoPrint;
use PHPUnit\Framework\TestCase;

class ManagesLanguagesTest extends TestCase
{
    public function test_retrieving_installed_languages()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'languages', [])->andReturn(
            new Response(200, [], '{"language_packs": {"_core": {"identifier": "_core","name": "Core","languages": []},"some_plugin": {"identifier": "some_plugin","name": "Some Plugin","languages": [{"locale": "de","locale_display": "Deutsch","locale_english": "German","last_update": 1474574597,"author": "Gina Häußge"},{"locale": "it","locale_display": "Italiano","locale_english": "Italian","last_update": 1470859680,"author": "The italian Transifex Team"}]}}}')
        );

        $languages = $octoPrint->languages();

        $this->assertCount(2, $languages);
        $this->assertCount(2, $languages['some_plugin']['languages']);
    }

    public function test_deleting_installed_languages()
    {
        $octoPrint = new OctoPrint('http://eevee.local', '123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('DELETE', 'languages/it/some_plugin', [])->andReturn(
            new Response(200, [], '{"language_packs": {"_core": {"identifier": "_core","name": "Core","languages": []},"some_plugin": {"identifier": "some_plugin","name": "Some Plugin","languages": [{"locale": "de","locale_display": "Deutsch","locale_english": "German","last_update": 1474574597,"author": "Gina Häußge"}]}}}')
        );

        $languages = $octoPrint->deleteLanguage('it', 'some_plugin');

        $this->assertCount(2, $languages);
        $this->assertCount(1, $languages['some_plugin']['languages']);
    }

}
