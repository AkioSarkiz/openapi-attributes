<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Pets;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property\Boolean;
use OpenApiGenerator\Attributes\Property\File;
use OpenApiGenerator\Attributes\Property\Number;
use OpenApiGenerator\Attributes\Property\Obj;
use OpenApiGenerator\Attributes\Property\Str;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Types\PropertyType;

#[
    Info('PetController'),
]
class PetController
{
    #[
        Post('pet/{petId}/uploadImage', ['pet'], 'uploads an image', contentType: 'multipart/form-data'),
        Number('petId'),
        Str('filename'),
        File('file', description: 'binary', example: null, format: 'binary'),
        Obj('test', properties: [
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

        Response(200, 'description', contentType: 'multipart/form-data'),
        Boolean('success'),
        Obj('data', properties: [
            'data' => PropertyType::ARRAY,
            'item' => PropertyType::STRING,

            'secondObject' => [
                'type' => PropertyType::STRING,
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