<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use OpenApiGenerator\Builders\SchemaBuilder\Common as CommonSchemaBuilder;
use OpenApiGenerator\Contracts\Attribute as AttributeContract;
use OpenApiGenerator\Types\PropertyType;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_ALL)]
class Property implements AttributeContract
{
    /**
     * Common namespace from SchemaBuilder.
     *
     * @var string|null
     */
    private ?string $commonNamespacePath = null;

    public function __construct(
        private string $type = '',
        private string $property = '',
        private string $description = '',
        private mixed $example = null,
        private ?string $format = null,
        private ?array $enum = null,
        private mixed $properties = null,
        private mixed $items = null,
        private ?int $minItems = null,
        private ?int $maxItems = null,
        private ?string $ref = null,
    ) {
        //
    }

    public function jsonSerialize(): array
    {
        if ($this->ref) {
            return $this->formatRef();
        }

        $data = [
            'type' => $this->getType(),
            'format' => $this->getFormat(),
            'description' => $this->description,
            'example' => $this->example,
            'enum' => $this->enum,
            'items' => $this->items,
            'minItems' => $this->minItems,
            'maxItems' => $this->maxItems,
        ];

        // Create objects properties from array properties. Recursive serialize objects.
        if ($this->getType() === PropertyType::OBJECT) {
            foreach ($this->formatProperties() as $property) {
                $propObject = $this->createFromArray($property);
                $data['properties'][$propObject->getProperty()] = $propObject->jsonSerialize();
            }
        } elseif ($this->getType() === PropertyType::ARRAY) {
            $data['items'] = is_array($this->items) ? $this->items : ['type' => $this->items];
        }

        return removeEmptyValues($data);
    }

    public function getType(): string
    {
        if ($this->properties) {
            return PropertyType::OBJECT;
        } elseif ($this->items) {
            return PropertyType::ARRAY;
        } elseif ($this->type === 'file') {
            return PropertyType::STRING;
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

    #[Pure]
    public function createFromArray(array $data): self
    {
        $args = [];
        $format = [
            // key => default value
            'type' => '',
            'property' => '',
            'description' => '',
            'example' => null,
            'format' => null,
            'enum' => null,
            'properties' => null,
            'items' => null,
            'minItems' => null,
            'maxItems' => null,
            'ref' => null,
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

    /**
     * @return array
     */
    #[ArrayShape(['$ref' => "string"])]
    private function formatRef(): array
    {
        if (class_exists($this->ref)) {
            $this->ref = $this->commonNamespacePath
                ? CommonSchemaBuilder::formatSchemaName($this->ref, $this->commonNamespacePath)
                : str_replace('\\', '_', $this->ref);
        }

        if (!str_starts_with($this->ref, '#/components/schemas/')) {
            $this->ref = "#/components/schemas/{$this->ref}";
        }

        return [
            '$ref' => $this->ref,
        ];
    }

    public function setCommonNamespace(?string $commonNamespacePath): void
    {
        $this->commonNamespacePath = $commonNamespacePath;
    }
}
