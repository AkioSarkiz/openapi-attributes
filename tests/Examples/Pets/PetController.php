<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\Pets;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Parameter;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Types\PropertyType;

#[
    Info('Pet project')
]
class PetController
{
    #[
        Post('pet/{petId}/uploadImage', ['pet'], 'uploads an image', contentType: 'multipart/form-data'),
        Parameter('petId', 'integer'),
        Property('filename', 'string'),
        Property('file', 'file', format: 'binary'),
        Property('test', PropertyType::OBJECT, properties: [
            'data' => PropertyType::STRING,
            'item' => [
                'type' => PropertyType::STRING,
            ],
            'anotherObject' => [
                'type' => PropertyType::OBJECT,
                'properties' => [
                    'output.json' => PropertyType::STRING,
                ],
            ],
        ]),

        Response(200, 'description',  contentType: 'multipart/form-data'),
        Property('success', 'boolean'),
        Property('test', PropertyType::OBJECT, properties: [
            'data' => PropertyType::STRING,
            'item' => PropertyType::STRING,
            'anotherObject' => [
                'type' => PropertyType::OBJECT,
                'properties' => [
                    'output.json' => PropertyType::STRING,
                ],
            ],
        ]),
    ]
    public function store(): void
    {
        //
    }
}