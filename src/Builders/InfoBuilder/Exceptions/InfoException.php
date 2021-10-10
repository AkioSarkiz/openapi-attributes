<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\InfoBuilder\Exceptions;

use JetBrains\PhpStorm\Pure;
use OpenApiGenerator\Exceptions\OpenApiException;

class InfoException extends OpenApiException
{
    #[Pure]
    public static function duplicateInfoTag(): self
    {
        return new self('[Error] Duplicate info tag');
    }

    #[Pure]
    public static function notFound(): self
    {
        return new self('[Error] Not found info tag');
    }
}
