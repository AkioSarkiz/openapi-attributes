<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JsonSerializable;
use OpenApiGenerator\Types\ItemsType;
use OpenApiGenerator\Types\SchemaType;

/**
 * Define response object.
 *
 * @see https://swagger.io/specification/#response-object
 */
#[Attribute]
class Response implements JsonSerializable
{
    private ?Schema $schema = null;

    public function __construct(
        private int $code = 200,
        private string $description = '',
        private string $type = SchemaType::OBJECT,
        ?string $ref = null,
        private string $contentType = 'application/json',
    ){
        if ($ref) {
            $this->schema = new Schema(type: $type);
            $this->schema->addProperty(match($type) {
                SchemaType::OBJECT => new RefProperty($ref),
                SchemaType::ARRAY => new PropertyItems(ItemsType::REF, $ref),
            });
        }
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
}
