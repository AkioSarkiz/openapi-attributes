<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder;

/**
 * Context of build path.
 */
class PathBuilderContext
{
    public array $attributes;
    public object $routeInstance;
    public array $routeData;
    public array $properties = [];
    public array $responses = [];
    public array $parameters = [];
    public ?object $lastResponseInstance = null;
    public ?array $lastResponseData = null;
}
