<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes\Schema;

use Attribute;
use OpenApiGenerator\Attributes\Schema;
use OpenApiGenerator\Types\SchemaType;

#[Attribute(Attribute::TARGET_CLASS)]
class Model extends Schema
{
    /**
     * @inheritDoc
     */
    public function __construct(
        string $name = '',
        array $required = [],
        string $type = SchemaType::OBJECT,
        string $mediaType = 'application/json',
    ) {
        parent::__construct($name, $required, $type, true, $mediaType);
    }
}
