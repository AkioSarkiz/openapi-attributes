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
        private string $responseType = '',
        private string $schemaType = SchemaType::OBJECT,
        private ?string $ref = null,
    )
    {
        if ($ref) {
            $this->schema = new Schema(type: $schemaType);

            if ($schemaType === SchemaType::OBJECT) {
                $this->schema->addProperty(new RefProperty($ref));
            } elseif ($schemaType === SchemaType::ARRAY) {
                $this->schema->addProperty(new PropertyItems(ItemsType::REF, $ref));
            }
        }
    }

    public function getResponseType(): ?string
    {
        return $this->responseType;
    }

    public function setResponseType(string $responseType): void
    {
        $this->responseType = $responseType;
    }

    public function jsonSerialize(): array
    {
        $array = [
            $this->code => [
                'description' => $this->description
            ]
        ];

        if ($this->schema) {
            $array[$this->code]['content'] = $this->schema;
        }

        return $array;
    }

    public function setSchema(Schema $schema): void
    {
        $this->schema = $schema;
    }
}
