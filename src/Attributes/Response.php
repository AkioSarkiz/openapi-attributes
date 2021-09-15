<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use OpenApiGenerator\Types\PropertyType;
use OpenApiGenerator\Types\SchemaType;

/**
 * Define response object.
 *
 * @see https://swagger.io/specification/#response-object
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_METHOD)]
class Response implements JsonSerializable
{
    private ?Schema $schema = null;

    public function __construct(
        private int $code = 200,
        private string $description = '',
        private string $type = SchemaType::OBJECT,
        ?string $ref = null,
        private string $contentType = 'application/json',
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        $array = [
            'description' => $this->description
        ];

        if ($this->schema) {
            $array['content'] = $this->schema;
        }

        return $array;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

    #[Pure]
    public function getChildProp(): string
    {
        return match ($this->getType()) {
            PropertyType::ARRAY => 'items',
            default => 'properties',
        };
    }
}
