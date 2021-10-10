<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\ServerBuilder;

use JetBrains\PhpStorm\ArrayShape;
use OpenApiGenerator\Attributes\Server;
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
        if (count($class->getAttributes(Server::class, ReflectionAttribute::IS_INSTANCEOF))) {
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
        $servers = [];

        foreach ($this->stack as $class) {
            $serverAttributes = $class->getAttributes(Server::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($serverAttributes as $item) {
                $servers[] = $item->newInstance()->jsonSerialize();
            }
        }

        return count($servers) ? ['key' => 'servers', 'data' => $servers] : [];
    }

    /**
     * @inheritDoc
     */
    public function setSharedStore(SharedStore $store): void
    {
        // no supported
    }
}
