<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder\Pipes;

use OpenApiGenerator\Attributes\Property;
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
            $prop = $this->context->lastResponseInstance->getChildProp();

            if (!$schema) {
                $schema = [
                    'type' => $this->context->lastResponseInstance->getType(),
                    $prop => [],
                ];
            }

            switch ($prop) {
                case 'items':
                    $schema[$prop] = $propInstance->jsonSerialize();
                    break;

                default:
                    $schema[$prop][$propInstance->getProperty()] = $propInstance->jsonSerialize();
                    break;
            }
        } else {
            $this->context->properties[$propInstance->getProperty()] = $propInstance->jsonSerialize();
        }

        $this->skipAnotherPipelines();
    }
}