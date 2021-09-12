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
        $dataSchema = $classInstance->jsonSerialize();

        foreach ($class->getAttributes(Property::class) as $property) {
            $dataSchema['properties'][] = $property->newInstance()->jsonSerialize();
        }

        $this->context->name = $classInstance->getName();
        $this->context->schema = $dataSchema;
        $this->skipAnotherPipelines();
    }
}
