<?php

use OpenApiGenerator\Tests\Examples\MediaController\MediaController;

require __DIR__ . '/vendor/autoload.php';

$class = MediaController::class;
$ref = new ReflectionClass($class);
$methods = $ref->getMethods();

dd($methods[0]->getAttributes());
