<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use League\Pipeline\Pipeline;
use OpenApiGenerator\Attributes\Route;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Attributes\Route\Patch;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Attributes\Route\Put;
use OpenApiGenerator\Builders\PathBuilder\Exceptions\SkipAnotherPipelines;
use OpenApiGenerator\Builders\PathBuilder\Pipes\ParameterPipe;
use OpenApiGenerator\Builders\PathBuilder\Pipes\PropertyPipe;
use OpenApiGenerator\Builders\PathBuilder\Pipes\ResponsePipe;
use OpenApiGenerator\Contracts\BuilderInterface;
use ReflectionClass;
use ReflectionMethod;

class Builder implements BuilderInterface
{
    private array $stack = [];
    private PathBuilderContext $context;

    /**
     * @inheritDoc
     */
    public function append(ReflectionClass $class): BuilderInterface
    {
        $this->stack[] = $class;

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape(['key' => "string", 'data' => "array"])]
    public function build(): array
    {
        return [
            'key' => 'paths',
            'data' => $this->getPaths(),
        ];
    }

    /**
     * @return array
     */
    private function getPaths(): array
    {
        $paths = [];

        foreach ($this->stack as $class) {
            $methods = $class->getMethods();

            foreach ($methods as $method) {
                $paths = array_merge_recursive($paths, $this->handleMethod($method));
            }
        }

        return $paths;
    }

    /**
     * @param  ReflectionMethod  $method
     * @return array
     */
    private function handleMethod(ReflectionMethod $method): array
    {
        if (!$this->isSupportedMethod($method)) {
            return [];
        }

        $this->context = new PathBuilderContext();
        $this->context->attributes = $method->getAttributes();
        $this->context->routeInstance = array_shift($this->context->attributes)->newInstance();
        $this->context->routeData = $this->context->routeInstance->jsonSerialize();
        $pipeline = (new Pipeline())
            ->pipe(new ParameterPipe($this->context))
            ->pipe(new ResponsePipe($this->context))
            ->pipe(new PropertyPipe($this->context));

        foreach ($this->context->attributes as $attribute) {
            try {
                $pipeline->process($attribute);
            } catch (SkipAnotherPipelines) {
                continue;
            }
        }

        $root = &$this->context->routeData[$this->context->routeInstance->getRoute()][$this->context->routeInstance->getMethod()];

        setArrayByPath($root, 'responses', $this->context->responses);
        setArrayByPath($root, 'parameters', $this->context->parameters);
        setArrayByPath($root, "requestBody.content.{$this->context->routeInstance->getContentType()}.schema", [
            'type' => 'object',
            'properties' => $this->context->properties,
        ]);

        return $this->context->routeData;
    }

    /**
     * Check reflection method. Are supported him or not.
     *
     * @param  ReflectionMethod  $method
     * @return bool
     */
    #[Pure]
    private function isSupportedMethod(ReflectionMethod $method): bool
    {
        return count($method->getAttributes(Route::class))
            || count($method->getAttributes(Get::class))
            || count($method->getAttributes(Post::class))
            || count($method->getAttributes(Patch::class))
            || count($method->getAttributes(Put::class));
    }
}
