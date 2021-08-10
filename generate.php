<?php

declare(strict_types=1);

use Symfony\Component\Finder\Finder;

$autoload_path = null;

foreach ([__DIR__ . '/../../autoload.php', __DIR__ . '/vendor/autoload.php'] as $autoload) {
    if (file_exists($autoload)) {
        $autoload_path = $autoload;
        break;
    }
}

if (!$autoload_path) {
    echo 'Not found autoload file. Please, check composer packages.';
    die;
}

require $autoload_path;

$files = Finder::create()->files()->name('*.php')->in($argv[1]);

foreach ($files as $autoload) {
    include_once $autoload->getPathName();
}

$generator = \OpenApiGenerator\Generator::create()->generate();

$schema = stripslashes(json_encode($generator, JSON_PRETTY_PRINT));

file_put_contents($argv[2] . '/openapi.json', $schema);
