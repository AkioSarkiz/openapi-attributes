<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Collect\Http\Schemas\Another;

use OpenApiGenerator\Attributes\Schema;

#[Schema(model: true)]
class User
{
    private string $nameAlt;
    private string $secretAlt;
}