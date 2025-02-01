<?php
namespace App\Services;


use Illuminate\Support\Facades\Log;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LoggingMiddlewareService
{
    public static function logRequest()
    {

        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                // Log the request here
                Log::info('Request:', [
                    'method' => $request->getMethod(),
                    'uri' => (string) $request->getUri(),
                    'headers' => $request->getHeaders(),
                    'body' => (string) $request->getBody(),
                ]);

                return $handler($request, $options)->then(
                    function (ResponseInterface $response) {
                        // Log the response here
                        Log::info('Response:', [
                            'status' => $response->getStatusCode(),
                            'body' => (string) $response->getBody(),
                        ]);
                        return $response;
                    }
                );
            };
        };
    }
}
