<?php

namespace Woody\Middleware\Exception;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Woody\Http\Server\Middleware\MiddlewareInterface;

/**
 * Class ExceptionMiddleware
 *
 * @package Woody\Middleware\Exception
 */
class ExceptionMiddleware implements MiddlewareInterface
{

    /**
     * ExceptionMiddleware constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param bool $debug
     *
     * @return bool
     */
    public function isEnabled(bool $debug): bool
    {
        return true;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch(HttpExceptionInterface $e) {
            $response = new Response($e->getStatusCode(), $e->getHeaders(), $e->getMessage());
        } catch (\Throwable $t) {
            $response = new Response(500, [], 'Internal Error');
        }

        return $response;
    }
}
