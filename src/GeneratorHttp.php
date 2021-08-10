<?php

declare(strict_types=1);

namespace OpenApiGenerator;

use OpenApiGenerator\Attributes\MediaProperty;
use OpenApiGenerator\Attributes\Parameter;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\PropertyItems;
use OpenApiGenerator\Attributes\RequestBody;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route;
use OpenApiGenerator\Attributes\Route\Delete;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Attributes\Route\Patch;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Attributes\Route\Put;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionParameter;
use Throwable;

class GeneratorHttp
{
    private array $paths = [];

    public function append(ReflectionClass $reflectionClass)
    {
        foreach ($reflectionClass->getMethods() as $method) {
            $methodAttributes = $method->getAttributes();

            try {
                $route = array_filter($methodAttributes, fn($attribute) => $attribute->newInstance() instanceof Route);
            } catch (Throwable) {
                continue;
            }

            if (count($route) < 1) {
                continue;
            }

            $parameters = $this->getParameters($method->getParameters());

            $pathBuilder = new PathBuilder();
            $pathBuilder->setRequestBody(new RequestBody());

            // Add method Attributes to the builder
            foreach ($methodAttributes as $attribute) {
                $name = $attribute->getName();
                $instance = $attribute->newInstance();

                switch ($name) {
                    case Route::class:
                    case Get::class:
                    case Post::class:
                    case Patch::class:
                    case Put::class:
                    case Delete::class:
                        $pathBuilder->setRoute($instance, $parameters);
                        break;

                    case RequestBody::class:
                        $pathBuilder->setRequestBody($instance);
                        break;

                    case Property::class:
                        $pathBuilder->addProperty($instance);
                        break;

                    case PropertyItems::class:
                        $pathBuilder->setPropertyItems($instance);
                        break;

                    case MediaProperty::class:
                        $pathBuilder->setMediaProperty($instance);
                        break;

                    case Response::class:
                        $pathBuilder->setResponse($instance);
                        break;
                }
            }

            if ($route = $pathBuilder->getRoute()) {
                $this->paths[] = $route;
            }
        }
    }

    private function getParameters(array $methodParameters): array
    {
        return array_map(
            function (ReflectionParameter $param) {
                return array_map(
                    function (ReflectionAttribute $attribute) use ($param) {
                        $instance = $attribute->newInstance();
                        $instance->setName($param->getName());
                        $instance->setParamType((string)$param->getType());

                        return $instance;
                    },
                    $param->getAttributes(Parameter::class, ReflectionAttribute::IS_INSTANCEOF)
                );
            },
            $methodParameters
        );
    }

    public function build(): array
    {
        $paths = [];

        foreach ($this->paths as $path) {
            $paths = isset($paths[$path->getRoute()])
                ? $this->mergeRoutes($paths, $path)
                : array_merge($paths, $path->jsonSerialize());
        }

        return $paths;
    }

    private function mergeRoutes($paths, Route $route): array
    {
        $toMerge = $route->jsonSerialize();
        $routeToMerge = reset($toMerge);
        $methodToMerge = reset($routeToMerge);
        $paths[$route->getRoute()][$route->getMethod()] = $methodToMerge;

        return $paths;
    }
}
