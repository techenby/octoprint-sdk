<?php

namespace TechEnby\OctoPrint;

use Exception;
use Illuminate\Support\Str;
use TechEnby\OctoPrint\Exceptions\FailedActionException;
use TechEnby\OctoPrint\Exceptions\NotFoundException;
use TechEnby\OctoPrint\Exceptions\TimeoutException;
use TechEnby\OctoPrint\Exceptions\ValidationException;
use Psr\Http\Message\ResponseInterface;

trait MakesHttpRequests
{
    /**
     * Make a GET request to OctoPrint servers and return the response.
     *
     * @param  string  $uri
     * @return mixed
     */
    public function get($uri, array $payload = [])
    {
        if(!empty($payload)) {
            return $this->request('GET', $uri, $payload);
        }

        return $this->request('GET', $uri);
    }

    /**
     * Make a POST request to OctoPrint servers and return the response.
     *
     * @param  string  $uri
     * @param  array  $payload
     * @return mixed
     */
    public function post($uri, array $payload = [])
    {
        return $this->request('POST', $uri, $payload);
    }

    /**
     * Make a PATCH request to OctoPrint servers and return the response.
     *
     * @param  string  $uri
     * @param  array  $payload
     * @return mixed
     */
    public function patch($uri, array $payload = [])
    {
        return $this->request('PATCH', $uri, $payload);
    }

    /**
     * Make a PUT request to OctoPrint servers and return the response.
     *
     * @param  string  $uri
     * @param  array  $payload
     * @return mixed
     */
    public function put($uri, array $payload = [])
    {
        return $this->request('PUT', $uri, $payload);
    }

    /**
     * Make a DELETE request to OctoPrint servers and return the response.
     *
     * @param  string  $uri
     * @param  array  $payload
     * @return mixed
     */
    public function delete($uri, array $payload = [])
    {
        return $this->request('DELETE', $uri, $payload);
    }

    public function upload($uri, $path, $contents)
    {
        if(str_contains($path, '/')) {
            $filename = basename($path);
            $path = str_replace($filename, '', $path);

            $response = $this->guzzle->post($uri, [
                'multipart' => [
                    ['name' => 'path', 'contents' => $path],
                    ['name' => 'file', 'filename' => $filename, 'contents' => $contents]
                ]
            ]);
        } else {
            $response = $this->guzzle->post($uri, [
                'multipart' => [
                    ['name' => 'file', 'filename' => $path, 'contents' => $contents]
                ]
            ]);
        }

        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true) ?: $responseBody;
    }

    /**
     * Make request to OctoPrint servers and return the response.
     *
     * @param  string  $verb
     * @param  string  $uri
     * @param  array  $payload
     * @return mixed
     */
    protected function request($verb, $uri, array $payload = [])
    {
        if(getenv('APP_ENV') === 'testing') {
            return $this->fakeRequest($verb, $uri, $payload);
        }

        $response = $this->guzzle->request($verb, $uri, $payload);

        $statusCode = $response->getStatusCode();

        if ($statusCode < 200 || $statusCode > 299) {
            return $this->handleRequestError($response);
        }

        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true) ?: $responseBody;
    }

    /**
     * Handle the request error.
     *
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @return void
     *
     * @throws \Exception
     * @throws \TechEnby\OctoPrint\Exceptions\FailedActionException
     * @throws \TechEnby\OctoPrint\Exceptions\NotFoundException
     * @throws \TechEnby\OctoPrint\Exceptions\ValidationException
     */
    protected function handleRequestError(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 422) {
            throw new ValidationException(json_decode((string) $response->getBody(), true));
        }

        if ($response->getStatusCode() == 404) {
            throw new NotFoundException();
        }

        if ($response->getStatusCode() == 400) {
            throw new FailedActionException((string) $response->getBody());
        }

        throw new Exception((string) $response->getBody());
    }

    /**
     * Retry the callback or fail after x seconds.
     *
     * @param  int  $timeout
     * @param  callable  $callback
     * @param  int  $sleep
     * @return mixed
     *
     * @throws \TechEnby\OctoPrint\Exceptions\TimeoutException
     */
    public function retry($timeout, $callback, $sleep = 5)
    {
        $start = time();

        beginning:

        if ($output = $callback()) {
            return $output;
        }

        if (time() - $start < $timeout) {
            sleep($sleep);

            goto beginning;
        }

        throw new TimeoutException($output);
    }

    private function fakeRequest($verb, $uri, $payload)
    {
        $baseUrl = (string) $this->guzzle->getConfig('base_uri');
        $parts = explode('/', $uri);
        $result = 'good';
        $verb = strtolower($verb);
        $type = $parts[0];

        if (isset($parts[1])) {
            $type = Str::singular($type);
        }
        if (Str::contains($baseUrl, 'bad')) {
            $result = 'bad';
        }

        $response = json_decode(file_get_contents(__DIR__ . "/responses/{$result}/{$verb}/{$type}.json"), true);

        if($result === 'bad') {
            return throw new Exception((string) $response);
        }

        return $response;
    }
}
