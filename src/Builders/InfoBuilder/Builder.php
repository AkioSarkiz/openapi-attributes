<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\InfoBuilder;

use JetBrains\PhpStorm\ArrayShape;
use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Builders\InfoBuilder\Exceptions\InfoException;
use OpenApiGenerator\Builders\SharedStore;
use OpenApiGenerator\Contracts\Builder as BuilderContract;
use ReflectionAttribute;
use ReflectionClass;

class Builder implements BuilderContract
{
    private array $stack = [];

    /**
     * @inheritDoc
     */
    public function append(ReflectionClass $class): BuilderContract
    {
        if ($class->getAttributes(Info::class, ReflectionAttribute::IS_INSTANCEOF)) {
            $this->stack[] = $class;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape(['key' => "string", 'data' => "array"])]
    public function build(): array
    {
        if (count($this->stack) === 0) {
            throw InfoException::notFound();
        }

        if (count($this->stack) > 1) {
            throw InfoException::duplicateInfoTag();
        }

        return [
            'key' => 'info',
            'data' => $this->stack[0]->getAttributes(
                Info::class, ReflectionAttribute::IS_INSTANCEOF
            )[0]->newInstance()->jsonSerialize(),
        ];
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
        // no supported.
    }
}
