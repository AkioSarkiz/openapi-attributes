<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Collect\Http\Schemas;

use OpenApiGenerator\Attributes\Schema;

#[Schema(model: true)]
class User
{
    private string $name;
    private string $secret;
}
