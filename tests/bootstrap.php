<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

// @phpstan-ignore-next-line - method always exists in current version but check is for forward compatibility
if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if (!empty($_SERVER['APP_DEBUG'])) {
    umask(0000);
}
