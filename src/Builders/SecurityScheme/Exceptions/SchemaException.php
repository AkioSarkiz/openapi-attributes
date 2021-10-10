<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\SecurityScheme\Exceptions;

use JetBrains\PhpStorm\Pure;
use OpenApiGenerator\Exceptions\OpenapiException;

class SchemaException extends OpenapiException
{
    #[Pure]
    public static function duplicateSchemaName(
        string $schemaName
    ): self {
        return new self("[Error] Duplicate schema name: $schemaName");
    }
}
