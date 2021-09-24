<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Pets;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Parameter;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Types\PropertyType;

#[
    Info('PetController')
]
class PetController
{
    #[
        Post('pet/{petId}/uploadImage', ['pet'], 'uploads an image', contentType: 'multipart/form-data'),
        Parameter('petId', 'integer'),
        Property('string', 'filename'),
        Property('file', 'file', description: 'binary', example: null, format: 'binary'),
        Property(PropertyType::OBJECT, 'test', properties: [
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
        Property('boolean', 'success'),
        Property(PropertyType::OBJECT, 'test', properties: [
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