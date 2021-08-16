<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use OpenApiGenerator\Attributes\Parameter;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Attributes\Route\Patch;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Attributes\Route\Put;
use OpenApiGenerator\Interfaces\BuilderInterface;
use ReflectionClass;
use ReflectionMethod;

class PathBuilder implements BuilderInterface
{
    private array $stack = [];

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
                $paths = array_merge_recursive($paths,  $this->handleMethod($method));
            }
        }

        return $paths;
    }

    /**
     * @param ReflectionMethod $method
     * @return array
     */
    private function handleMethod(ReflectionMethod $method): array
    {
        if (!$this->isSupportedMethod($method)) {
            return [];
        }

        $attributes = $method->getAttributes();
        $routeInstance = array_shift($attributes)->newInstance();
        $dataRoute = $routeInstance->jsonSerialize();
        $properties = [];
        $responses = [];
        $parameters = [];
        $lastResponseData = null;
        $lastResponseInstance = null;

        foreach ($attributes as $attribute) {
            if ($attribute->getName() == Parameter::class) {
                $parameters[] = $attribute->newInstance()->jsonSerialize();
            } elseif ($attribute->getName() === Response::class) {
                $responseInstance = $attribute->newInstance();
                $responses[$responseInstance->getCode()] = $responseInstance->jsonSerialize();
                $lastResponseData = &$responses[$responseInstance->getCode()];
                $lastResponseInstance = &$responseInstance;
            } elseif ($attribute->getName() === Property::class) {
                $propInstance = $attribute->newInstance();

                if ($lastResponseData) {
                    $schema = &$lastResponseData['content'][$lastResponseInstance->getContentType()]['schema'];

                    if (!$schema) {
                        $schema = [
                            'type' => $lastResponseInstance->getType(),
                            'properties' => [],
                        ];
                    }

                    $schema['properties'][$propInstance->getProperty()] = $propInstance->jsonSerialize();
                } else {
                    $properties[$propInstance->getProperty()] = $propInstance->jsonSerialize();
                }
            }
        }

        $root = &$dataRoute[$routeInstance->getRoute()][$routeInstance->getMethod()];

        setArrayByPath($root, 'responses', $responses);
        setArrayByPath($root, 'parameters', $parameters);
        setArrayByPath($root, "requestBody.content.{$routeInstance->getContentType()}.schema", [
            'type' => 'object',
            'properties' => $properties,
        ]);

       return $dataRoute;
    }

    /**
     * @param ReflectionMethod $method
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