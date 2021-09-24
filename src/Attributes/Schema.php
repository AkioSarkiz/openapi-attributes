<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use OpenApiGenerator\Types\SchemaType;
use OpenApiGenerator\Contracts\Attribute as AttributeContract;

/**
 * Define schema item.
 *
 * @see https://swagger.io/specification/#schema-object
 */
#[Attribute(Attribute::TARGET_CLASS)]
class Schema implements AttributeContract
{
    private array $properties = [];

    /**
     * Create new instance schema.
     *
     * @param  string  $name Name of the schema. Using class name if not defined.
     * @param  array  $required List of required properties.
     * @param  string  $type Schema type, supported types: array and object. By default, object.
     * @param  bool  $model Auto fetches all properties class and put them to schema.
     * @param  string  $mediaType Media type of schema. For body, response request.
     */
    public function __construct(
        private string $name = '',
        private array $required = [],
        private string $type = SchemaType::OBJECT,
        private bool $model = false,
        private string $mediaType = 'application/json',
    ) {
        //
    }

    public function jsonSerialize(): array
    {
        $schema = [
            'type' => $this->type
        ];

        if ($this->type === SchemaType::ARRAY) {
            $schema += json_decode(json_encode(reset($this->properties)), true);
        } elseif ($this->type === SchemaType::OBJECT) {
            $array = [];

            if ($this->required) {
                $array['required'] = $this->required;
            }

            foreach ($this->properties as $property) {
                if ($property instanceof Property) {
                    $array['properties'][$property->getProperty()] = $property;
                }
            }

            $schema += $array;
        }

        return [
            $this->mediaType => [
                'schema' => $schema
            ]
        ];
    }

    public function isModelSchema(): bool
    {
        return $this->model;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
