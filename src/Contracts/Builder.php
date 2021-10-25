<?php

declare(strict_types=1);

namespace OpenApiGenerator\Contracts;

use OpenApiGenerator\Builders\SharedStore;
use OpenApiGenerator\Exceptions\OpenapiException;
use ReflectionClass;

interface Builder
{
    /**
     * Add class to builder.
     *
     * @param  ReflectionClass  $class
     * @return Builder
     */
    public function append(ReflectionClass $class): Builder;

    /**
     * Build array.
     *
     * Builder must return array [
     *      // path in schema, for example: 'components.securitySchemes'
     *      'key' => string,
     *      // data for path
     *      'data' => array
     * ]
     *
     * If schema has error, builder must throw exception OpenapiException.
     * If schema data is empty, return the empty array.
     *
     * @return array
     * @throws OpenapiException
     */
    public function build(): array;

    /**
     * Set shared store.
     *
     * @param  SharedStore  $store
     * @return void
     */
    public function setSharedStore(SharedStore $store): void;

    /**
     * Register dependencies & set share data.
     *
     * @return void
     */
    public function boot(): void;
}
