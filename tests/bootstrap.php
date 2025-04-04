<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} else {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

// Run migrations for test database
passthru(sprintf(
    'php "%s/../bin/console" doctrine:migrations:migrate --env=test --no-interaction',
    __DIR__
));
