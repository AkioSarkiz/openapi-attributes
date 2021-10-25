<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\SecurityScheme;

use JetBrains\PhpStorm\ArrayShape;
use OpenApiGenerator\Attributes\SecurityScheme;
use OpenApiGenerator\Builders\SharedStore;
use OpenApiGenerator\Contracts\Builder as BuilderContract;
use OpenApiGenerator\Builders\SecurityScheme\Exceptions\SchemaException;
use ReflectionAttribute;
use ReflectionClass;

/**
 * Builder section #components/secureSchemas.
 */
class Builder implements BuilderContract
{
    /**
     * Stack classes for build.
     *
     * @var array
     */
    private array $stackClasses = [];

    /**
     * @inheritDoc
     */
    public function append(ReflectionClass $class): BuilderContract
    {
        if (count($class->getAttributes(SecurityScheme::class, ReflectionAttribute::IS_INSTANCEOF))) {
            $this->stackClasses[] = $class;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape(['key' => "string", 'data' => "array"])]
    public function build(): array
    {
        $securitySchemas = [];

        foreach ($this->stackClasses as $class) {
            $securitySchemasAttributes = $class->getAttributes(SecurityScheme::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($securitySchemasAttributes as $item) {
                $data = $item->newInstance()->jsonSerialize();
                $key = $data['securityKey'];
                unset($data['securityKey']);

                if (array_key_exists($key, $securitySchemas)) {
                    throw SchemaException::duplicateSchemaName($key);
                }

                $securitySchemas[$key] = $data;
            }
        }

        return count($securitySchemas) ? ['key' => 'components.securitySchemes', 'data' => $securitySchemas] : [];
    }

    /**
     * @inheritDoc
     */
    public function setSharedStore(SharedStore $store): void
    {
        // no supported.
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        // not supported.
    }
}
