<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders;

use JetBrains\PhpStorm\ArrayShape;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Schema;
use OpenApiGenerator\Interfaces\BuilderInterface;
use ReflectionClass;

class SchemaBuilder implements BuilderInterface
{
    private array $stack = [];

    /**
     * @inheritDoc
     */
    public function append(ReflectionClass $class): BuilderInterface
    {
        if ($class->getAttributes(Schema::class)) {
            $this->stack[] = $class;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape(['key' => "string", 'data' => "array"])]
    public function build(): array
    {
        return [
            'key' => 'components.schemas',
            'data' => $this->getSchemas(),
        ];
    }

    /**
     * @return array
     */
    private function getSchemas(): array
    {
        $schemas = [];

         foreach ($this->stack as $class) {
             $schema = $class->getAttributes(Schema::class)[0];
             $dataSchema = $schema->newInstance()->jsonSerialize();

             foreach ($class->getAttributes(Property::class) as $property) {
                 $dataSchema['properties'][] = $property->newInstance()->jsonSerialize();
             }

             $schemas[] = $dataSchema;
         }

         return $schemas;
    }
}
