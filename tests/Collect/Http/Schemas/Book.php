<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Collect\Http\Schemas;

use OpenApiGenerator\Attributes\Schema;

#[Schema(model: true)]
class Book
{
    private string $title;
    private int $rate;
    private string $created_at;
    private string $updated_at;
}