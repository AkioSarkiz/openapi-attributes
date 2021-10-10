<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\SchemaBuilder;

/**
 * Context of build one schema.
 */
class SchemaBuilderContext
{
    public string $name;
    public array $schema;
    public ?string $commonNamespacePath = null;
}
