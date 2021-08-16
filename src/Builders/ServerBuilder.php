<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders;

use JetBrains\PhpStorm\ArrayShape;
use OpenApiGenerator\Attributes\Server;
use OpenApiGenerator\Interfaces\BuilderInterface;
use ReflectionClass;

class ServerBuilder implements BuilderInterface
{
    private array $stack = [];

    /**
     * @inheritDoc
     */
    public function append(ReflectionClass $class): BuilderInterface
    {
        if (count($class->getAttributes(Server::class))) {
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
            $serverAttributes = $class->getAttributes(Server::class);

            foreach ($serverAttributes as $item) {
                $servers[] = $item->newInstance()->jsonSerialize();
            }
        }

        return [
            'key' => 'servers',
            'data' => $servers,
        ];
    }
}