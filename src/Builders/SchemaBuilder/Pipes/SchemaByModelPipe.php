<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\SchemaBuilder\Pipes;

use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Schema;
use OpenApiGenerator\Builders\SchemaBuilder\Common;
use ReflectionAttribute;
use ReflectionClass;

class SchemaByModelPipe extends Pipe
{
    private ReflectionClass $class;
    private Schema $instanceAttribute;

    /**
     * @inheritDoc
     */
    public function __invoke(ReflectionClass $class): ReflectionClass
    {
        $this->class = $class;
        $instance = $class->getAttributes(Schema::class, ReflectionAttribute::IS_INSTANCEOF)[0]->newInstance();

        // Only Schema attribute is supported.
        if (!$instance instanceof Schema) {
            $this->skipAnotherPipelines();
        }

        $this->instanceAttribute = $instance;

        if (!$this->instanceAttribute->isModelSchema()) {
            return $class;
        }

        $this->context->name = $this->getName();
        $this->context->schema = $this->buildSchema();

        $this->skipAnotherPipelines();
    }

    /**
     * Get name schema.
     *
     * @return string
     */
    private function getName(): string
    {
        $name = $this->instanceAttribute->getName();

        if ($name) {
            return $name;
        }

        if ($this->context->commonNamespacePath) {
            return Common::formatSchemaName($this->class->getName(), $this->context->commonNamespacePath);
        } else {
            return str_replace('\\', '_', $this->class->getName());
        }
    }

    /**
     * Build schema data.
     *
     * @return array
     */
    public function buildSchema(): array
    {
        $properties = [];

        foreach ($this->class->getProperties() as $property) {
            $data = [];
            $attributes = $property->getAttributes(Property::class);

            if (count($attributes)) {
                $data = $attributes[0]->newInstance()->jsonSerialize();
            }

            if ($property->hasType()) {
                $formatType = $this->formatTypeName(
                    $property->getType()->getName()
                );
            }

            $properties[$property->getName()] = array_merge($formatType, $data);
        }

        return compact('properties');
    }

    /**
     * @param  string  $type
     * @return array
     */
    private function formatTypeName(string $type): array
    {
        return match ($type) {
            'int' => ['type' => 'number', 'format' => 'int64'],
            'float' => ['type' => 'number', 'format' => 'float'],
            'bool' => ['type' => 'boolean'],
            default => compact('type'),
        };
    }
}
