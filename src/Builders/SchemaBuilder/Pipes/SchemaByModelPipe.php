<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\SchemaBuilder\Pipes;

use OpenApiGenerator\Attributes\Schema;
use ReflectionClass;

class SchemaByModelPipe extends BasePipe
{
    private ReflectionClass $class;
    private Schema $instanceAttribute;

    /**
     * @inheritDoc
     */
    public function __invoke(ReflectionClass $class): ReflectionClass
    {
        $this->class = $class;
        $instance = $class->getAttributes(Schema::class)[0]->newInstance();

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

        $path = explode('\\', $this->class->getName());

        return array_pop($path);
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
            $properties[$property->getName()] = $this->formatTypeName(
                $property->getType()->getName()
            );
        }

        return compact('properties');
    }

    /**
     * @param string $type
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
