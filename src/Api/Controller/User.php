<?php

namespace UserApp\Api\Controller;

use UserApp\Domain\User\Command\Login;
use UserApp\Domain\User\Command\Register;
use UserApp\Domain\User\Exception\UserNotFoundException;
use UserApp\Domain\User\Exception\IncorrectPasswordException;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Silex\Application;
use Silex\ControllerProviderInterface;

class User implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $factory = $app['controllers_factory'];

        $factory->post(
            '/register',
            function (Register $command) {
                var_dump($command);
                exit;
            }
        )
        ->value('controller', 'register')
        ->value('success_handler', function ($view, $request) {
            return new RedirectResponse("/");
        })
        ->convert('request', function ($request) {
            return new Register($request->request->all());
        });

        $factory->post(
            '/login',
            'interactor.user_login'
        )
        ->value('controller', 'login')
        ->value('success_handler', function ($view, $request) {
            $request->getSession()->set('current_user', $view->user);
            return new RedirectResponse("/");
        })
        ->value('error_handlers', [
            UserNotFoundException::class => function ($e) use ($app) {
                return [
                    'errors' => 'incorrect email provided',
                    'email'  => $e->email,
                ];
            },
            IncorrectPasswordException::class => function ($e) use ($app) {
                return [
                    'errors' => 'invalid credentials provided',
                    'email'  => $e->email,
                ];
            },
        ])
        ->convert('request', function ($request) use ($app) {
            return new Login($request->request->all());
        });

        return $factory;
    }
}