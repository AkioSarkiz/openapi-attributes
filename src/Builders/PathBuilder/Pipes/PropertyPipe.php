<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder\Pipes;

use OpenApiGenerator\Attributes\Property;
use ReflectionAttribute;

class PropertyPipe extends Pipe
{
    /**
     * @inheritDoc
     */
    public function __invoke(ReflectionAttribute $attribute): ReflectionAttribute
    {
        if (!$attribute->newInstance() instanceof Property) {
            return $attribute;
        }

        /** @var Property $propInstance */
        $propInstance = $attribute->newInstance();
        $propInstance->setCommonNamespace($this->context->commonNamespacePath);

        if ($this->context->lastResponseData) {
            $this->handleWithResponse($propInstance);
        } else {
            $this->handleWithoutResponse($propInstance);
        }

        $this->skipAnotherPipelines();
    }

    /**
     * Handle prop when exists response.
     *
     * @param  Property  $instance
     * @return void
     */
    private function handleWithResponse(Property $instance): void
    {
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
                $schema[$prop] = $instance->jsonSerialize();
                break;

            default:
                $schema[$prop][$instance->getProperty()] = $instance->jsonSerialize();
                break;
        }
    }

    /**
     * Handle prop when not exists response.
     *
     * @param  Property  $prop
     * @return void
     */
    private function handleWithoutResponse(Property $prop): void
    {
        $this->context->properties[$prop->getProperty()] = $prop->jsonSerialize();
    }
}