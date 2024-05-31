<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$configurator = App\Bootstrap::boot();
$configurator->setDebugMode(true);
$configurator->enableTracy(__DIR__ . '/../log');
$configurator->addConfig(__DIR__ . '/../config/common.neon');
$container = $configurator->createContainer();
$application = $container->getByType(Nette\Application\Application::class);
$application->run();
