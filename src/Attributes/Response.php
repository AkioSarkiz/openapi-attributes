<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JetBrains\PhpStorm\Pure;
use OpenApiGenerator\Types\PropertyType;
use OpenApiGenerator\Types\SchemaType;
use OpenApiGenerator\Contracts\Attribute as AttributeContract;

/**
 * Define response object.
 *
 * @see https://swagger.io/specification/#response-object
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_METHOD)]
class Response implements AttributeContract
{
    private ?Schema $schema = null;

    /**
     * @param  int  $code  Http code of response.
     * @param  string  $description  A short description of the response. CommonMark syntax MAY be used for rich text representation.
     * @param  string  $type  Type of response. Supported types array and object. Use SchemaType class.
     * @param  string|null  $ref  Reference of response.
     * @param  string  $contentType  Mime content type of response.
     *
     * @param  array  $headers  Maps a header name to its definition. RFC7230 states header names are case insensitive.
     *      If a response header is defined with the name "Content-Type", it SHALL be ignored.
     */
    public function __construct(
        private int $code,
        private string $description,
        private string $type = SchemaType::OBJECT,
        private ?string $ref = null,
        private string $contentType = 'application/json',
        private array $headers = [],
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        $data = [
            'description' => $this->description
        ];

        if ($this->schema) {
            $data['content'] = $this->schema;
        }

        return $data;
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

    public function getRef(): ?string
    {
        return $this->ref;
    }
}
