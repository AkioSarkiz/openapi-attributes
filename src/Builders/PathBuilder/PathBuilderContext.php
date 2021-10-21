<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\PathBuilder;

use OpenApiGenerator\Attributes\Route;

/**
 * Context of build path.
 */
class PathBuilderContext
{
    public array $attributes;
    public Route $routeInstance;
    public array $routeData;
    public array $properties = [];
    public array $responses = [];
    public array $parameters = [];
    public ?object $lastResponseInstance = null;
    public ?array $lastResponseData = null;

    /**
     * Common namespace path of schemas. It was got in SchemaBuilder and push to sharedStore.
     * If this path isn't equals null, we must pass this prop to instance Property.
     *
     * @var string|null
     */
    public ?string $commonNamespacePath = null;

    public array $responseRef = [];
}
