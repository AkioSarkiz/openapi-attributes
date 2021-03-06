<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\SchemaModel;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Schema;
use OpenApiGenerator\Attributes\Schema\Model;

#[
    Info('SchemaModel'),

    Model,
]
class SchemaModel
{
    public string $name;
    public bool $is_banned;
    public float $price;

    #[
        Property(
            description: 'The age of person',
            example: 123,
            format: 'int32',
        ),
    ]
    public int $age;
}
