<?php

declare(strict_types=1);

namespace OpenApiGenerator;

use OpenApiGenerator\Builders\InfoBuilder\Builder as InfoBuilder;
use OpenApiGenerator\Builders\PathBuilder\Builder as PathBuilder;
use OpenApiGenerator\Builders\SchemaBuilder\Builder as SchemaBuilder;
use OpenApiGenerator\Builders\SecurityScheme\Builder as SecuritySchemeBuilder;
use OpenApiGenerator\Builders\ServerBuilder\Builder as ServerBuilder;
use OpenApiGenerator\Contracts\Builder;
use OpenApiGenerator\Contracts\ManagerBuilders as ManagerBuildersContract;

class ManagerBuilders implements ManagerBuildersContract
{
    /**
     * Cached builders.
     *
     * @var Builder[]
     */
    private array $cache;

    /**
     * @return Builder[]
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
     * @return Builder[]
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
