<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder\Pipes;

use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Builders\SchemaBuilder\Common;
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

        /** @var Response $responseInstance */
        $responseInstance = $attribute->newInstance();
        $this->context->responses[$responseInstance->getCode()] = $responseInstance->jsonSerialize();
        $this->context->lastResponseData = &$this->context->responses[$responseInstance->getCode()];
        $this->context->lastResponseInstance = &$responseInstance;

        if ($ref = $responseInstance->getRef()) {
            $this->context->responses[$responseInstance->getCode()]['content'][$responseInstance->getContentType()]['schema']['$ref'] =
                $this->context->commonNamespacePath
                    ? '#/components/schemas/' . Common::formatSchemaName($ref, $this->context->commonNamespacePath)
                    : $ref;
        }

        $this->skipAnotherPipelines();
    }
}