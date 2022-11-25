<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use GuzzleHttp\Psr7\Request;
use Symfony\Component\DependencyInjection\Reference;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

use challenge\routing\HttpRouter;
use challenge\Application;
use challenge\actions\Instructions;
use challenge\render\TwigHtmlRenderer;

return static function (ContainerConfigurator $container) {
    $routing_paths = [
        '/' => new Reference(Instructions::class),
    ];
    $routing_objects = [
        TwigHtmlRenderer::class => new Reference(TwigHtmlRenderer::class),
    ];

    $container->parameters()->set('template.path', APP_PATH . '/templates');

    $services = $container->services();

    // Renderer
    $services->set('twigLoader', FilesystemLoader::class)->args(['%template.path%']);
    $services->set('twigDebugExtension', DebugExtension::class);
    $services->set('twigEnvironment', Environment::class)
        ->args([new Reference('twigLoader'), ['debug' => true]])
        ->call('addExtension', [new Reference('twigDebugExtension')]);
    $services->set(TwigHtmlRenderer::class, TwigHtmlRenderer::class)->args([new Reference('twigEnvironment')]);

    // Actions
    $services->set(Instructions::class, Instructions::class);

    // Routing
    $services->set('httpRequest', Request::class)->args([$_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']]);
    $services->set('httpRouter', HttpRouter::class)->args([
        new Reference('httpRequest'),
        service_locator($routing_paths),
        service_locator($routing_objects),
    ]);

    $services->set('app', Application::class)->args([new Reference('httpRouter')]);
};
