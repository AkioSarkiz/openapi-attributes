<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes\Route;

use Attribute;
use OpenApiGenerator\Attributes\Route;

#[Attribute]
class Patch extends Route
{
    public function __construct(
        string $route,
        array $tags = [],
        string $summary = '',
        string $description = '',
        mixed $security = null,
        string $contentType = 'application/json',
    ) {
        parent::__construct(Route::PATCH, $route, $tags, $summary, $description, $security, $contentType);
    }
}
