<?php

namespace ab\Front;

abstract class TwigRenderer
{
    public static function loadAndRender(array $templateSearchPaths, string $templateName, array $context = []) : string
    {
        $loader = new \Twig\Loader\FilesystemLoader($templateSearchPaths);
        $twig = new \Twig\Environment($loader);

        $template = $twig->load($templateName);
        $result = $template->render($context);

        return $result;
    }
}