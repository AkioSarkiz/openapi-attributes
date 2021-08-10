<?php

declare(strict_types=1);

namespace OpenApiGenerator\Exceptions;

use JetBrains\PhpStorm\Pure;

class DefinitionCheckerException extends OpenapiException
{
    #[Pure]
    public static function missingField(
        string $field
    ): self
    {
        return new self("[Error] Missing field: $field");
    }

    #[Pure]
    public static function wrongFormat(
        string $field,
        string $expectingFormat
    ): self
    {
        return new self("[Error] Wrong format for the field: $field. Expecting format: $expectingFormat");
    }
}
