<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Collect\Http\Controllers;

use OpenApiGenerator\Attributes\Property\Boolean;
use OpenApiGenerator\Attributes\Property\Obj;
use OpenApiGenerator\Attributes\Property\Str;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Types\PropertyType;
use OpenApiGenerator\Types\SchemaType;

class ListController extends Controller
{
    #[
        Get('list'),

        Response(200, 'get list', type: SchemaType::ARRAY),
        Str(example: 'word', minItems: 5, maxItems: 500),

        Response(201, 'success created', type: SchemaType::ARRAY),
        Boolean,

        Response(500, 'server error', type: SchemaType::ARRAY),
        Obj(properties: [
            'code' => PropertyType::INT,
            'message' => PropertyType::STRING,

            'stack' => [
                'type' => 'array',
                'items' => PropertyType::STRING,
            ],
        ]),
    ]
    public function getListStrings(): void
    {
        //
    }
}
