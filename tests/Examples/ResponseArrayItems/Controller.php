<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\ResponseArrayItems;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Parameter;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Attributes\SecurityScheme;
use OpenApiGenerator\Attributes\Server;
use OpenApiGenerator\Types\PropertyType;

#[
    Info('ResponseArrayItems')
]
class Controller
{
    #[
        Get('/path/{id}', ['Dummy'], 'Dummy path'),

        Response(200, type: 'array'),
        Property(PropertyType::OBJECT, properties: [
            'name' => PropertyType::STRING,
            'password' => PropertyType::STRING,
            'age' => PropertyType::INT,
        ]),

        Response(400, type: 'array'),
        Property(PropertyType::STRING),

        Response(500, type: 'array'),
        Property(PropertyType::INT),
    ]
    public function get(float $id): void {
        //
    }
}
