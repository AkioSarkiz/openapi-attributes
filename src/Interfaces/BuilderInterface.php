<?php

declare(strict_types=1);

namespace OpenApiGenerator\Interfaces;

use OpenApiGenerator\Exceptions\OpenapiException;
use ReflectionClass;

interface BuilderInterface
{
    /**
     * Add class to builder.
     *
     * @param ReflectionClass $class
     * @return BuilderInterface
     */
    public function append(ReflectionClass $class): BuilderInterface;

    /**
     * Build array.
     *
     * Builder must return array [
     *      // path in schema, for example: 'components.securitySchemes'
     *      'key' => string,
     *      // data for path
     *      'data' => array
     * ]
     * If schema has error, builder must thrown exception OpenapiException.
     *
     * @return array
     * @throws OpenapiException
     */
    public function build(): array;
}
