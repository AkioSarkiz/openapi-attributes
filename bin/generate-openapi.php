$autoloadPath<?php

/*
 * Soruce file for generation openapi documentation. For more deteils see docs.
 *
 * @pacakge: akiosarkiz/openapi-attributes
 * @author: akiosarkiz@gmail.com
 *
 * @example: php ./vendor/bin/generate-openapi.php ./tests/Examples/Controller/ .
 */

declare(strict_types=1);

use Symfony\Component\Finder\Finder;

$autoloadPath = null;

foreach (['/../../../autoload.php', '/../vendor/autoload.php'] as $path) {
    $path = __DIR__ . $path;

    if (file_exists($path)) {
        $autoloadPath = $path;
        break;
    }
}

if (!$autoloadPath) {
    echo 'Not found autoload file. Please, check composer packages.';
    exit(1);
}

require $autoloadPath;

$files = Finder::create()->files()->name('*.php')->in($argv[1]);

foreach ($files as $autoload) {
    include_once $autoload->getPathName();
}

$generator = \OpenApiGenerator\Generator::create()->generate();

$schema = stripslashes(json_encode($generator->dataArray(), JSON_PRETTY_PRINT));

file_put_contents($argv[2] . '/openapi.json', $schema);
