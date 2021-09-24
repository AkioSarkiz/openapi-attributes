<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\SimpleController;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Types\PropertyType;

#[
    Info('SimpleController')
]
class SimpleController
{
    #[
        Get('simple', ['simple'], 'simple path'),
        Property(PropertyType::STRING, 'test'),

        Response(200, 'simple response'),
    ]
    public function get(): void
    {
        //
    }
}
