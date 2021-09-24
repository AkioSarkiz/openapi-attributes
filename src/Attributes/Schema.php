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
    private bool $noMedia = false;

    /**
     * Create new instance schema.
     *
     * @param  string  $name Name of the schema. Using class name if not defined.
     * @param  array  $required List of required properties.
     * @param  string  $type Schema type, supported types: array and object. By default, object.
     * @param  bool  $model Auto fetches all properties class and put them to schema.
     */
    public function __construct(
        private string $name = '',
        private array $required = [],
        private string $type = SchemaType::OBJECT,
        private bool $model = false,
    ) {
        //
    }

    public function getName(): ?string
    {
        return $this->name;
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

        // This is especially used for parameters which don't have media
        if ($this->noMedia) {
            return $schema;
        }

        return [
            $this->getMediaType() => [
                'schema' => $schema
            ]
        ];
    }

    private function getMediaType(): string
    {
        $hasMediaProp = array_filter(
            $this->properties,
            fn(?Property $property): bool => $property instanceof MediaProperty
        );

        // Has a MediaProperty object, get the first - and normally only on - property
        if (count($hasMediaProp) > 0) {
            $property = reset($this->properties);
            return $property->getContentMediaType();
        }

        // By default, return json type
        return 'application/json';
    }

    public function addProperty(Property $property): void
    {
        $this->properties[] = $property;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setNoMedia(bool $noMedia): void
    {
        $this->noMedia = $noMedia;
    }

    public function isModelSchema(): bool
    {
        return $this->model;
    }
}
