<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes\Property;

use Attribute;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Types\PropertyType;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_ALL)]
class File extends Property
{
    public function __construct(
        string $property = '',
        string $description = '',
        mixed $example = null,
        ?string $format = null,
        ?array $enum = null,
        mixed $properties = null,
        mixed $items = null,
        ?int $minItems = null,
        ?int $maxItems = null,
    ) {
        parent::__construct(
            PropertyType::FILE,
            $property,
            $description,
            $example,
            $format,
            $enum,
            $properties,
            $items,
            $minItems,
            $maxItems
        );
    }
}
