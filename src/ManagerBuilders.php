<?php

declare(strict_types=1);

namespace OpenApiGenerator;

use OpenApiGenerator\Builders\InfoBuilder;
use OpenApiGenerator\Builders\PathBuilder\Builder as PathBuilder;
use OpenApiGenerator\Builders\SchemaBuilder\Builder as SchemaBuilder;
use OpenApiGenerator\Builders\SecuritySchemeBuilder;
use OpenApiGenerator\Builders\ServerBuilder;
use OpenApiGenerator\Interfaces\BuilderInterface;

class ManagerBuilders
{
    /**
     * Cached builders.
     *
     * @var array
     */
    private array $cache;

    /**
     * @return array
     */
    public function define(): array
    {
        return [
            SecuritySchemeBuilder::class,
            SchemaBuilder::class,
            ServerBuilder::class,
            InfoBuilder::class,
            PathBuilder::class,
        ];
    }

    /**
     * @return BuilderInterface[]
     */
    public function getAvailableBuilders(): array
    {
        if (isset($this->cache)) {
            return $this->cache;
        }

        $this->cache = $this->define();

        return $this->cache;
    }
}
