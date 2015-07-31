<?php

namespace UserApp\Api;

use UserApp\Domain\User\Command\RegisterUser;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/app.php';
$console = new Application();

$console
    ->register('init')
    ->setDescription('Initialize the api')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        //\Domain\Eventing\MySqlEventStore::createSchema($app['db']);
    });

$console
    ->register('populate-test-data')
    ->setCode(function() use ($app) {
        // add some SQL
    });

$console
    ->register('create-user')
    ->setDefinition([
        new InputArgument('id', InputArgument::REQUIRED),
        new InputArgument('name', InputArgument::REQUIRED),
        new InputArgument('email', InputArgument::REQUIRED),
        new InputArgument('passwordHash', InputArgument::REQUIRED),
    ])
    ->setDescription('Create a user')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $app['interactor.user_register'](new RegisterUser([
            'id'       => $input->getArgument('id'),
            'name'     => $input->getArgument('name'),
            'email'    => $input->getArgument('email'),
            'password' => $input->getArgument('passwordHash')
        ]));
    });

$console->run();
