<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\SchemaBuilder;

use JetBrains\PhpStorm\ArrayShape;
use League\Pipeline\Pipeline;
use OpenApiGenerator\Attributes\Schema;
use OpenApiGenerator\Builders\SchemaBuilder\Exceptions\SkipAnotherPipelines;
use OpenApiGenerator\Builders\SchemaBuilder\Pipes\BaseSerializationPipe;
use OpenApiGenerator\Builders\SchemaBuilder\Pipes\SchemaByModelPipe;
use OpenApiGenerator\Contracts\BuilderInterface;
use ReflectionClass;

class Builder implements BuilderInterface
{
    private array $stack = [];

    /**
     * @inheritDoc
     */
    public function append(ReflectionClass $class): BuilderInterface
    {
        if ($class->getAttributes(Schema::class)) {
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
        return [
            'key' => 'components.schemas',
            'data' => $this->getSchemas(),
        ];
    }

    /**
     * @return array
     */
    private function getSchemas(): array
    {
        $schemas = [];

        foreach ($this->stack as $class) {
            $context = new SchemaBuilderContext();
            $this->processPipes($context, $class);
            $schemas[$context->name] = $context->schema;
        }

        return $schemas;
    }

    public function pipes(): array
    {
        return [
            SchemaByModelPipe::class,
            BaseSerializationPipe::class,
        ];
    }

    /**
     * Process pipeline and return result.
     *
     * @param SchemaBuilderContext $context
     * @param mixed $payload
     * @return mixed
     */
    public function processPipes(SchemaBuilderContext &$context, mixed $payload): mixed
    {
        $pipeline = new Pipeline();

        foreach ($this->pipes() as $pipe) {
            $pipeline = $pipeline->pipe(new $pipe($context));
        }

        try {
            return $pipeline->process($payload);
        } catch (SkipAnotherPipelines) {
            return null;
        }
    }
}
