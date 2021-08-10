<?php

declare(strict_types=1);

namespace OpenApiGenerator\Exceptions;

use JetBrains\PhpStorm\Pure;

class GeneratorException extends OpenapiException
{
    #[Pure]
    public static function duplicateSchemaName(
        string $schemaName
    ): self
    {
        return new self("[Error] Duplicate schema name: $schemaName");
    }
}
