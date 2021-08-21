<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use OpenApiGenerator\Interfaces\PropertyInterface;
use OpenApiGenerator\Types\PropertyType;

/**
 * This represents an open api property.
 * The property must have a type and a property name and can have a description and an example
 * If the property is an array, a PropertyItems must be set
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_ALL)]
class Property implements PropertyInterface, JsonSerializable, PropertyType
{
    private ?PropertyItems $propertyItems = null;

    public function __construct(
        private string $property,
        private string $type,
        private string $description = '',
        private mixed $example = null,
        private ?string $format = null,
        private ?array $enum = null,
        private mixed $properties = null,
        private mixed $items = null,
        private ?int $minItems = null,
        private ?int $maxItems = null,
    ){
        //
    }

    public function setPropertyItems(PropertyItems $propertyItems): void
    {
        $this->propertyItems = $propertyItems;
        $this->propertyItems->setExample($this->example);
    }

    public function jsonSerialize(): array
    {
        if ($this->getType() === PropertyType::ARRAY) {
            if ($this->propertyItems) {
                return $this->propertyItems->jsonSerialize();
            }
        }

        $data = [
            'type' => $this->getType(),
            'format' => $this->getFormat(),
            'description' => $this->description,
            'enum' => $this->enum,
            'items' => $this->items,
            'minItems' => $this->minItems,
            'maxItems' => $this->maxItems,
        ];

        // Create objects properties from array properties. Recursive serialize objects.
        if ($this->getType() === PropertyType::OBJECT && $this->properties) {
            foreach ($this->formatProperties() as $property) {
                $propObject = $this->createFromArray($property);
                $data['properties'][$propObject->getProperty()] = $propObject->jsonSerialize();
            }
        }

        return removeEmptyValues($data);
    }

    public function getType(): string
    {
        if ($this->properties) {
            return self::OBJECT;
        } elseif ($this->type === 'file') {
            return self::STRING;
        } else {
            return $this->type;
        }
    }

    private function formatProperties(): array
    {
        $format = [];

        foreach ($this->properties as $name => $property) {
            $data = [
                'property' => $name,
            ];

            if (is_array($property)) {
                $data = array_merge($data, $property);
            } else {
                $data['type'] = $property;
            }

            $format[] = $data;
        }

        return $format;
    }

    public function createFromArray(array $data): self
    {
        $args = [];
        $format = [
            'property' => '',
            'type' => '',
            'description' => '',
            'example' => null,
            'format' => null,
            'enum' => null,
            'properties' => null,
        ];

        foreach ($format as $key => $default) {
            $args[] = array_key_exists($key, $data) ? $data[$key] : $default;
        }

        return new self(...$args);
    }

    public function getProperty(): ?string
    {
        return $this->property;
    }

    #[Pure]
    private function getFormat(): ?string
    {
        return $this->type === 'file' ? 'binary' : $this->format;
    }
}
