<?php

namespace TechEnby\OctoPrint;

use GuzzleHttp\Client as HttpClient;
use TechEnby\OctoPrint\Resources\User;

class OctoPrint
{
    use MakesHttpRequests,
        Actions\ManagesAuthentication,
        Actions\ManagesConnection,
        Actions\ManagesFiles,
        Actions\ManagesJobs,
        Actions\ManagesLanguages,
        Actions\ManagesPrinter,
        Actions\ManagesPrinterProfiles,
        Actions\ManagesServer,
        Actions\ManagesVersion;

    /**
     * The OctoPrint Url.
     *
     * @var string
     */
    protected $url;

    /**
     * The OctoPrint API Key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The Guzzle HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    public $guzzle;

    /**
     * Number of seconds a request is retried.
     *
     * @var int
     */
    public $timeout = 30;

    /**
     * Create a new OctoPrint instance.
     *
     * @param  string|null  $apiKey
     * @param  \GuzzleHttp\Client|null  $guzzle
     * @return void
     */
    public function __construct($url = null, $apiKey = null, HttpClient $guzzle = null)
    {
        if (! is_null($url) && ! is_null($apiKey)) {
            $this->setupClient($url, $apiKey, $guzzle);
        }

        if (! is_null($guzzle)) {
            $this->guzzle = $guzzle;
        }
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param  array  $collection
     * @param  string  $class
     * @param  array  $extraData
     * @return array
     */
    protected function transformCollection($collection, $class, $extraData = [])
    {
        return array_map(function ($data) use ($class, $extraData) {
            return new $class($data + $extraData, $this);
        }, $collection);
    }

    /**
     * Set the url and api key and setup the guzzle request object.
     *
     * @param  string  $apiKey
     * @param  \GuzzleHttp\Client|null  $guzzle
     * @return $this
     */
    public function setupClient($url, $apiKey, $guzzle = null)
    {
        if(str_contains($url, 'api')) {
            $this->url = $url;
        } else {
            $this->url = $url.'/api/';
        }
        $this->apiKey = $apiKey;

        $this->guzzle = $guzzle ?: new HttpClient([
            'base_uri' => $this->url,
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer '.$this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return $this;
    }

    /**
     * Set a new timeout.
     *
     * @param  int  $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Get the timeout.
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Get an authenticated user instance.
     *
     * @return \TechEnby\OctoPrint\Resources\User
     */
    public function user()
    {
        return new User($this->get('user')['user']);
    }
}
