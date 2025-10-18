<?php

/**
 * Local Development Importmap
 * 
 * This file is for the bundle's documentation site ONLY.
 * It is NOT distributed to consuming applications.
 * 
 * Users have their own importmap.php with their own dependencies.
 * Bundle controllers are auto-discovered via assets/controllers.json.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap' => [
        'version' => '5.3.8',
    ],
];
