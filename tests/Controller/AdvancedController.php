<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Controller;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Parameter;
use OpenApiGenerator\Attributes\Property\Obj;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Attributes\SecurityScheme;
use OpenApiGenerator\Attributes\Server;
use OpenApiGenerator\Types\PropertyType;

#[
    Info(
        'AdvancedController',
        '1.0.0',
        'description',
        'https://example.com/termsOfService',
        [
            'name' => 'API Support',
            'url' => 'https://example.com/support',
            'email' => 'support@output.json.com'
        ],
        [
            'name' => 'Apache 2.0',
            'url' => 'https://www.apache.org/licenses/LICENSE-2.0.html'
        ],
    ),

    Server('same server1', 'https//example.com'),
    Server('same server2', 'https//example.org'),

    SecurityScheme(
        'bearerAuth',
        'http',
        'bearerAuth',
        'header',
        'bearer',
        'JWT',
    ),
]
class AdvancedController
{
    #[
        Get('/path/{id}', ['Dummy'], 'Dummy path'),
        Parameter('id', 'integer', description: 'id of dummy'),
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

        Response(200, 'description'),
    ]
    public function get(float $id): void {
        //
    }
}
