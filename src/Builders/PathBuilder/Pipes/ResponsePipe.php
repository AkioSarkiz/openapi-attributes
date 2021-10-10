<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder\Pipes;

use OpenApiGenerator\Attributes\Response;
use ReflectionAttribute;

class ResponsePipe extends Pipe
{
    /**
     * @inheritDoc
     */
    public function __invoke(ReflectionAttribute $attribute): ReflectionAttribute
    {
        if ($attribute->getName() !== Response::class) {
            return $attribute;
        }

        $responseInstance = $attribute->newInstance();
        $this->context->responses[$responseInstance->getCode()] = $responseInstance->jsonSerialize();
        $this->context->lastResponseData = &$this->context->responses[$responseInstance->getCode()];
        $this->context->lastResponseInstance = &$responseInstance;

        $this->skipAnotherPipelines();
    }
}