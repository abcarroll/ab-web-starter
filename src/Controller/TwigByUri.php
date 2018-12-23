<?php

namespace ab\Front\Controller;

use Psr\Http\Message\RequestInterface;
use ab\Front\TwigRenderer;
use Zend\Diactoros\Response;

class TwigByUri
{
    public function __invoke(RequestInterface $request, array $args)
    {
        $route = $request->getUri()->getPath();
        if ($route === '/') {
            $route = 'home';
        }

        $templateFile = $route . '.twig.html';

        try {
            $result = TwigRenderer::loadAndRender([
                '../template/'
            ], $templateFile);
        } catch (\Throwable $exception) {
            $errorResponse = new Response();
            $errorResponse->getBody()->write("Exception when rendering template: [" . $exception->getCode() . "] " . $exception->getMessage());
            return $errorResponse->withStatus(500);
        }

        $response = new Response();
        $response->getBody()->write($result);

        return $response;
    }
}