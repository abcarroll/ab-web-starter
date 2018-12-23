<?php

namespace ab\Front;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;

class ServerRequestHandler
{
    public static function getServerRequestFromGlobals(): ServerRequestInterface
    {
        return ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
    }

    public static function route(ServerRequestInterface $request): ResponseInterface
    {
        $router = new \League\Route\Router();

        $routeData = file_get_contents('../routes.json');
        $routeData = json_decode($routeData, true);

        foreach ($routeData['routes'] as $route) {
            $mapping = $router->map($route[0], $route[1], $route[2]);
            if (isset($route[3]['host'])) {
                $mapping->setHost($route[3]['host']);
            }
            if (isset($route[3]['scheme'])) {
                $mapping->setScheme($route[3]['host']);
            }
        }

        if (empty($routeData)) {
            throw new \RuntimeException("Couldn't load route data (routes.json)");
        }

        return $router->dispatch($request);
    }

    public static function emit(ResponseInterface $response): void
    {
        (new \Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
    }

    public static function handleServerRequest()
    {
        static::emit(
            static::route(
                static::getServerRequestFromGlobals()
            )
        );
    }
}
