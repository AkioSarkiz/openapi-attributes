<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder\Pipes;

use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Builders\PathBuilder\Exceptions\SkipAnotherPipelines;
use ReflectionAttribute;

class PropertyPipe extends BasePipe
{
    /**
     * @inheritDoc
     */
    public function __invoke(ReflectionAttribute $attribute): ReflectionAttribute
    {
        if ($attribute->getName() !== Property::class) {
            return $attribute;
        }

        $propInstance = $attribute->newInstance();

        if ($this->context->lastResponseData) {
            $schema = &$this->context->lastResponseData['content'][$this->context->lastResponseInstance->getContentType()]['schema'];

            if (!$schema) {
                $schema = [
                    'type' => $this->context->lastResponseInstance->getType(),
                    'properties' => [],
                ];
            }

            $schema['properties'][$propInstance->getProperty()] = $propInstance->jsonSerialize();
        } else {
            $this->context->properties[$propInstance->getProperty()] = $propInstance->jsonSerialize();
        }

        throw new SkipAnotherPipelines();
    }
}