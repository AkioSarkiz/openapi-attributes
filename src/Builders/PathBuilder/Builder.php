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
use OpenApiGenerator\Builders\SharedStore;
use OpenApiGenerator\Contracts\Builder as BuilderContract;
use OpenApiGenerator\Types\SchemaType;
use ReflectionClass;
use ReflectionMethod;

class Builder implements BuilderContract
{
    private array $stack = [];
    private PathBuilderContext $context;
    private SharedStore $sharedStore;

    /**
     * @inheritDoc
     */
    public function append(ReflectionClass $class): Builder
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
        $paths = $this->getPaths();

        if (!count($paths)) {
            return [];
        }

        return [
            'key' => 'paths',
            'data' => $paths,
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
        $this->formatContext();
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

        $this->setResponses($root);
        $this->setParameters($root);
        $this->setProperties($root);

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

    /**
     * @param  array  $properties
     * @return array
     */
    private function formatPropertiesAsItems(array $properties): array
    {
        $items = [];

        foreach ($properties as $property) {
            $items = array_merge($property, $items);
        }

        return $items;
    }

    /**
     * Set properties for route.
     *
     * @param  array  $root
     * @return void
     */
    private function setProperties(array &$root): void
    {
        if (!count($this->context->properties)) {
            return;
        }

        if ($this->context->routeInstance->getSchemaType() === SchemaType::OBJECT) {
            setArrayByPath($root, "requestBody.content.{$this->context->routeInstance->getContentType()}.schema", [
                'type' => SchemaType::OBJECT,
                'required' => $this->context->routeInstance->getRequired(),
                'properties' => $this->context->properties,
            ]);
        } else {
            setArrayByPath($root, "requestBody.content.{$this->context->routeInstance->getContentType()}.schema", [
                'type' => SchemaType::ARRAY,
                'items' => $this->formatPropertiesAsItems($this->context->properties),
            ]);
        }
    }

    /**
     * Set parameters for route.
     *
     * @param  array  $root
     * @return void
     */
    private function setParameters(array &$root): void
    {
        if (!count($this->context->parameters)) {
            return;
        }

        setArrayByPath($root, 'parameters', $this->context->parameters);
    }

    /**
     * Set responses for route.
     *
     * @param  array  $root
     * @return void
     */
    private function setResponses(array &$root): void
    {
        if (!count($this->context->responses)) {
            return;
        }

        setArrayByPath($root, 'responses', $this->context->responses);
    }

    /**
     * @inheritDoc
     */
    public function setSharedStore(SharedStore $store): void
    {
        $this->sharedStore = $store;
    }

    /**
     * Format current object context.
     *
     * @return void
     */
    private function formatContext(): void
    {
        $commonNamespacePath = $this->sharedStore->get('schema:common_namespace');

        if ($commonNamespacePath) {
            $this->context->commonNamespacePath = $commonNamespacePath;
        }
    }
}
