<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder\Pipes;

use OpenApiGenerator\Builders\PathBuilder\Exceptions\SkipAnotherPipelines;
use OpenApiGenerator\Builders\PathBuilder\PathBuilderContext;
use ReflectionAttribute;

abstract class Pipe
{
    public function __construct(
        protected PathBuilderContext $context,
    ) {
        //
    }

    /**
     * @param  ReflectionAttribute  $attribute
     * @return ReflectionAttribute
     * @throws SkipAnotherPipelines
     */
    abstract public function __invoke(ReflectionAttribute $attribute): ReflectionAttribute;

    /**
     * @throws SkipAnotherPipelines
     */
    protected function skipAnotherPipelines(): void
    {
        throw new SkipAnotherPipelines();
    }
}
