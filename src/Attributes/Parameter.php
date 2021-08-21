<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * Define parameter object.
 *
 * Represents a parameter (e.g. /route/{id} where id is the parameter)
 * A schema is automatically set to generate the parameter type
 *
 * @see https://swagger.io/specification/#parameter-object.
 */
#[Attribute]
class Parameter implements JsonSerializable
{
    private array $schema = [];

    public function __construct(
        private string $type,
        private string $name,
        private ?string $description = null,
        private string $in = 'path',
        private ?bool $required = null,
        private mixed $example = '',
        private mixed $format = ''
    )
    {
        if ($in === 'path') {
            $this->required = true;
        }
    }

    public function setParamType(string $paramType): void
    {
        $this->schema = match ($paramType) {
            'int' => ['type' => 'integer'],
            'bool' => ['type' => 'boolean'],
            'float', 'double' => ['type' => 'number', 'format' => $paramType],
            'mixed' => [],
            default => ['type' => $paramType],
        };
    }

    #[ArrayShape([
        'name' => 'string',
        'in' => 'string',
        'schema' => 'array',
        'description' => 'string|null',
        'required' => 'bool|null'
    ])]
    public function jsonSerialize(): array
    {
        $data = [
            'name' => $this->name,
            'in' => $this->in,
            'schema' => $this->formatSchema(),
            'required' => $this->required,
            'description' => $this->description,
        ];

        return removeEmptyValues($data);
    }

    /**
     * Format schema for serialize to json.
     *
     * @return array
     */
    private function formatSchema(): array
    {
        $schema = $this->schema;
        $schema['type'] = $this->type;
        $schema['format'] = $this->format ?? $schema['format'];
        $schema['example'] = $this->example;

        return removeEmptyValues($schema);
    }
}
