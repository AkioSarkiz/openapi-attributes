<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders;

use JetBrains\PhpStorm\ArrayShape;
use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Exceptions\InfoException;
use OpenApiGenerator\Contracts\BuilderInterface;
use ReflectionAttribute;
use ReflectionClass;

class InfoBuilder implements BuilderInterface
{
    /**
     * @var array
     */
    private array $stack = [];

    /**
     * @inheritDoc
     */
    public function append(ReflectionClass $class): BuilderInterface
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
            'data' => $this->stack[0]->getAttributes(Info::class, ReflectionAttribute::IS_INSTANCEOF)[0]->newInstance()->jsonSerialize(),
        ];
    }
}
