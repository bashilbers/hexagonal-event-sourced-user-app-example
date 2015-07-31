<?php

namespace UserApp\Api;

use Domain\Eventing\RedisEventStore;
use UserApp\Domain\User\Entity\Repository\File\UserRepository as UserReadRepo;
use UserApp\Domain\User\Aggregates\UserRepository as UserWriteRepo;
use UserApp\Domain\User\Service\UppercasePasswordEncoder;
use UserApp\Domain\User\Command\Register as RegisterCommand;
use UserApp\Domain\User\Command\Login as LoginCommand;
use UserApp\Domain\User\CommandHandler\RegisterHandler;
use UserApp\Domain\User\CommandHandler\LoginHandler;

use Silex\Application;
use Silex\ServiceProviderInterface;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\InvokeInflector;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['event_store'] = $app->share(function ($app) {
            return new RedisEventStore(
                $app['predis']
            );
        });

        $app['user_repo'] = $app->share(function ($app) {
            return new UserReadRepo($app['user_repo.file']);
        });

        $app['user_write_repo'] = $app->share(function ($app) {
            return new UserWriteRepo(
                $app['event_store'],
                $app['event_bus']
            );
        });

        $app['command_bus'] = $app->share(function ($app) {
            $locator = new InMemoryLocator();
            $locator->addHandler(new RegisterHandler($app['user_repo'], $app['password_encoder']), RegisterCommand::class);
            $locator->addHandler(new LoginHandler(), LoginCommand::class);

            // Middleware is Tactician's plugin system. Even finding the handler and
            // executing it is a plugin that we're configuring here.
            $handlerMiddleware = new \League\Tactician\Handler\CommandHandlerMiddleware(
                new ClassNameExtractor(),
                $locator,
                new InvokeInflector()
            );

            return  new \League\Tactician\CommandBus([$handlerMiddleware]);
        });

        $app['event_bus'] = $app->share(function ($app) {

        });

        $app['password_encoder'] = $app->share(function ($app) {
            return new UppercasePasswordEncoder;
        });

        $app['event_handler.user_login'] = $app->share(function ($app) {
            return new UserLogin($app['user_repo'], $app['password_encoder']);
        });

        $app['event_handler.register_user'] = $app->share(function ($app) {
            return new RegisterUser($app['user_write_repo'], $app['password_encoder']);
        });
    }

    public function boot(Application $app)
    {

    }
}
