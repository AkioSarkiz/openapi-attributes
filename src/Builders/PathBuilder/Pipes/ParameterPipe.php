<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder\Pipes;

use OpenApiGenerator\Attributes\Parameter;
use ReflectionAttribute;

class ParameterPipe extends Pipe
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

        $this->skipAnotherPipelines();
    }
}