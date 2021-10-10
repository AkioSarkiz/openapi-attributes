<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\RequestBodyArrayItems;
use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Property\Obj;
use OpenApiGenerator\Attributes\Property\Str;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Types\PropertyType;
use OpenApiGenerator\Types\SchemaType;

#[
    Info('RequestBodyArrayItemsController')
]
class RequestBodyArrayItemsController
{
    #[
        Get('path/{id}', schemaType: SchemaType::ARRAY),
        Str,
    ]
    public function getString(float $id): void
    {
        //
    }

    #[
        Post('path/{id}', schemaType: SchemaType::ARRAY),
        Obj(properties: [
            'key' => PropertyType::STRING,
            'value' => PropertyType::STRING,

            'object' => [
                'type' => PropertyType::OBJECT,
                'properties' => [
                    'key' => PropertyType::STRING,
                    'value' => PropertyType::STRING,
                ],
            ],

            'available' => [
                'type' => PropertyType::ARRAY,
                'items' => 'string',
            ],

            'alternative' => [
                'type' => PropertyType::ARRAY,
                'items' => ['type' => 'string'],
            ]
        ]),
    ]
    public function getObject(float $id): void
    {
        //
    }
}