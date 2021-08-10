<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\Controller;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Parameter;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Attributes\SecurityScheme;
use OpenApiGenerator\Attributes\Server;
use OpenApiGenerator\Types\PropertyType;

#[
    Info(
        'title',
        '1.0.0',
        'description',
        'url terms Of Service',
        [
            'name' => 'API Support',
            'url' => 'https://www.output.json.com/support',
            'email' => 'support@output.json.com'
        ],
        [
            'name' => 'Apache 2.0',
            'url' => 'https://www.apache.org/licenses/LICENSE-2.0.html'
        ],
    ),
    Server('same server1', 'same url1'),
    Server('same server2', 'same url2'),
    SecurityScheme(
        'bearerAuth',
        'http',
        'bearerAuth',
        'header',
        'JWT',
        'bearer',
    ),
]
class Controller
{
    #[
        Get('/path/{id}', ['Dummy'], 'Dummy path'),
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
        Response(200),
    ]
    public function get(
        #[Parameter(example: '2')] float $id
    ): void {
        //
    }
}
