<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder\Pipes;

use OpenApiGenerator\Attributes\Parameter;
use OpenApiGenerator\Builders\PathBuilder\Exceptions\SkipAnotherPipelines;
use ReflectionAttribute;

class ParameterPipe extends BasePipe
{
    /**
     * @inheritDoc
     */
    public function __invoke(ReflectionAttribute $attribute): ReflectionAttribute
    {
        if ($attribute->getName() !== Parameter::class) {
            return $attribute;
        }

        $this->context->parameters[] = $attribute->newInstance()->jsonSerialize();

        throw new SkipAnotherPipelines();
    }
}