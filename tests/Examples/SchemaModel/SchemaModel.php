<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\SchemaModel;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Schema;

#[
    Info('test'),
    Schema(model: true),
]
class SchemaModel
{
    public string $name;
    public bool $is_banned;
    public float $price;
    public int $age;
}
