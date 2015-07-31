<?php

namespace UserApp\Api;

use UserApp\Api\Controller\User as UserController;
use Silex\Application;
use Igorw\Silex\ConfigServiceProvider;
use Predis\Silex\ClientServiceProvider as PredisServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelEvents;

$env = isset($_ENV['env']) ? $_ENV['env'] : 'dev';

$app = new Application();

$app->register(new MonologServiceProvider());
$app->register(new PredisServiceProvider());
$app->register(new ServiceControllerServiceProvider());

$app->register(new ConfigServiceProvider(__DIR__."/../../config/$env.json", [
    'storage_path'  => __DIR__.'/../../storage'
]));

$app->register(new ServiceProvider());

$app['resolver'] = $app->share($app->extend('resolver', function ($resolver, $app) {
    $resolver = new ControllerResolver($resolver, $app);

    return $resolver;
}));

$app->before(function (Request $request) use ($app) {
    $request->attributes->set('request', $request);
});

$app->error(function(\Exception $e, $code) use ($app) {
    $app['request']->attributes->set('failed', true);

    $errorHandlers = $app['request']->attributes->get('error_handlers', []);

    foreach ($errorHandlers as $type => $handler) {
        if ($e instanceof $type) {
            return $handler($e, $code, $app['request']);
        }
    }

    $message = 'We are sorry, but something went terribly wrong.';
    $data = [];
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;

        default:
            if ($app['debug']) {
                $data['exception']['message'] = $e->getMessage();
                $data['exception']['code']    = $e->getCode();
            }
    }

    $data['message'] = $message;

    return new JsonResponse($data, $code);
});

$app->on(KernelEvents::VIEW, function ($event) use ($app) {
    $view = $event->getControllerResult();

    var_dump($view);
    exit;

    if (is_null($view) || is_string($view)) {
        return;
    }

    $request = $event->getRequest();

    if (!$request->attributes->get('failed') && $request->attributes->has('success_handler')) {
        $handler = $request->attributes->get('success_handler');

        $view = $handler($view, $request);
        if ($view instanceof Response) {
            $event->setResponse($view);
            return;
        }
    }

    $view = (object) $view;
    $response = new \Symfony\Component\HttpFoundation\JsonResponse($view);
    $event->setResponse($response);
});

$app->mount('/users', new UserController());

return $app;
