<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\SchemaBuilder\Pipes;

use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Schema;
use ReflectionClass;

class BaseSerializationPipe extends BasePipe
{
    /**
     * @inheritDoc
     */
    public function __invoke(ReflectionClass $class): ReflectionClass
    {
        $schema = $class->getAttributes(Schema::class)[0];
        $classInstance = $schema->newInstance();
        $dataSchema = [];

        foreach ($class->getAttributes(Property::class) as $property) {
            $propertyInstance = $property->newInstance();
            $dataSchema['properties'][$propertyInstance->getProperty()] = $propertyInstance->jsonSerialize();
        }

        $this->context->name = $classInstance->getName();
        $this->context->schema = $dataSchema;

        $this->skipAnotherPipelines();
    }
}
