<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use OpenApiGenerator\Attributes\SecurityScheme;
use OpenApiGenerator\Exceptions\SchemaException;
use OpenApiGenerator\Interfaces\BuilderInterface;
use ReflectionClass;

/**
 * Class SecuritySchemeBuilder builder section #components/secureSchemas.
 *
 * @package OpenApiGenerator
 */
class SecuritySchemeBuilder implements BuilderInterface
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
    public function append(ReflectionClass $class): self
    {
        if (count($class->getAttributes(SecurityScheme::class))) {
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
        $result = [];

        foreach ($this->stackClasses as $class) {
            $securitySchemas = $class->getAttributes(SecurityScheme::class);

            foreach ($securitySchemas as $item) {
                $data = $item->newInstance()->jsonSerialize();
                $key = $data['securityKey'];
                unset($data['securityKey']);

                if (array_key_exists($key, $result)) {
                    throw SchemaException::duplicateSchemaName($key);
                }

                $result[$key] = $data;
            }
        }

        return [
            'key' => 'components.securitySchemes',
            'data' => $result,
        ];
    }
}
