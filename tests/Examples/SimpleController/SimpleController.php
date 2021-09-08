<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\SimpleController;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Types\PropertyType;

#[Info('title')]
class SimpleController
{
    #[
        Get('/path', ['Dummy'], 'Dummy path'),
        Property(PropertyType::STRING, 'test'),
        Response(200),
    ]
    public function get(): void
    {
        //
    }
}
