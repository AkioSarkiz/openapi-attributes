<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\ResponseArrayItems;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Types\PropertyType;

#[
    Info('ResponseArrayItems')
]
class ResponseArrayItems
{
    #[
        Get('/path/{id}', ['Dummy'], 'Dummy path'),

        Response(200, 'test', type: 'array'),
        Property(PropertyType::OBJECT, properties: [
            'name' => PropertyType::STRING,
            'password' => PropertyType::STRING,
            'age' => PropertyType::INT,
        ]),

        Response(400, 'test', type: 'array'),
        Property(PropertyType::STRING),

        Response(500, 'test', type: 'array'),
        Property(PropertyType::INT),
    ]
    public function get(float $id): void
    {
        //
    }
}
