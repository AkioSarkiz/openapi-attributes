<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes\Route;

use Attribute;
use JetBrains\PhpStorm\Pure;
use OpenApiGenerator\Attributes\Route;
use OpenApiGenerator\Types\SchemaType;

#[Attribute]
class Post extends Route
{
    #[Pure]
    public function __construct(
        string $route,
        array $tags = [],
        string $summary = '',
        string $description = '',
        mixed $security = null,
        string $contentType = 'application/json',
        string $schemaType = SchemaType::OBJECT,
        private array $required = [],
    ) {
        parent::__construct(Route::POST, $route, $tags, $summary, $description, $security, $contentType, $schemaType, $this->required);
    }
}
