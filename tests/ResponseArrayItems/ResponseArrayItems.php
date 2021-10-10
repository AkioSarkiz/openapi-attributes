<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\ResponseArrayItems;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Property\Number;
use OpenApiGenerator\Attributes\Property\Obj;
use OpenApiGenerator\Attributes\Property\Str;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Types\PropertyType;
use OpenApiGenerator\Types\SchemaType;

#[
    Info('ResponseArrayItems'),
]
class ResponseArrayItems
{
    #[
        Get('/path/{id}', ['Dummy'], 'Dummy path'),

        Response(200, 'test', type: 'array'),
        Obj(properties: [
            'name' => PropertyType::STRING,
            'password' => PropertyType::STRING,
            'age' => PropertyType::INT,
        ]),

        Response(400, 'test', type: SchemaType::ARRAY),
        Str,

        Response(500, 'test', type: SchemaType::ARRAY),
        Number,
    ]
    public function get(float $id): void
    {
        //
    }
}
