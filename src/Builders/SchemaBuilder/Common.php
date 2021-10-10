<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\SchemaBuilder;

class Common
{
    /**
     * @param  string  $className
     * @param  string  $commonNamespacePath
     * @return string
     */
    public static function formatSchemaName(string $className, string $commonNamespacePath): string
    {
        $formatted = substr($className, strlen($commonNamespacePath));

        return str_replace('\\', '_', strStartWithout($formatted, '\\'));
    }
}