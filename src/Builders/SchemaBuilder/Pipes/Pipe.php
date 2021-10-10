<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\SchemaBuilder\Pipes;

use OpenApiGenerator\Builders\SchemaBuilder\Exceptions\SkipAnotherPipelines;
use OpenApiGenerator\Builders\SchemaBuilder\SchemaBuilderContext;
use ReflectionClass;

abstract class Pipe
{
    public function __construct(
        protected SchemaBuilderContext &$context,
    ) {
        //
    }

    /**
     * @param  ReflectionClass  $class
     * @return ReflectionClass
     * @throws SkipAnotherPipelines
     */
    abstract public function __invoke(ReflectionClass $class): ReflectionClass;

    /**
     * @throws SkipAnotherPipelines
     */
    protected function skipAnotherPipelines(): void
    {
        throw new SkipAnotherPipelines();
    }
}
