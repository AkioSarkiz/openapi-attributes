<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders\SchemaBuilder;

use JetBrains\PhpStorm\ArrayShape;
use League\Pipeline\Pipeline;
use OpenApiGenerator\Attributes\Schema;
use OpenApiGenerator\Builders\SchemaBuilder\Exceptions\SkipAnotherPipelines;
use OpenApiGenerator\Builders\SchemaBuilder\Pipes\SerializationPipe;
use OpenApiGenerator\Builders\SchemaBuilder\Pipes\SchemaByModelPipe;
use OpenApiGenerator\Builders\SharedStore;
use OpenApiGenerator\Contracts\Builder as BuilderContract;
use ReflectionAttribute;
use ReflectionClass;

class Builder implements BuilderContract
{
    /** @var ReflectionClass[] */
    private array $stack = [];
    private SharedStore $sharedStore;

    /**
     * @inheritDoc
     */
    public function append(ReflectionClass $class): Builder
    {
        if ($class->getAttributes(Schema::class, ReflectionAttribute::IS_INSTANCEOF)) {
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
        $schema = $this->getSchemas();

        if (!count($schema)) {
            return [];
        }

        return [
            'key' => 'components.schemas',
            'data' => $schema,
        ];
    }

    /**
     * @return array
     */
    private function getSchemas(): array
    {
        $schemas = [];
        $commonNamespacePath = $this->getCommonNamespace();
        $this->sharedStore->set('schema:common_namespace', $commonNamespacePath);

        foreach ($this->stack as $class) {
            $context = new SchemaBuilderContext();
            $context->commonNamespacePath = $commonNamespacePath;
            $this->processPipes($context, $class);
            $schemas[$context->name] = $context->schema;
        }

        return $schemas;
    }

    public function pipes(): array
    {
        return [
            SchemaByModelPipe::class,
            SerializationPipe::class,
        ];
    }

    /**
     * Process pipeline and return result.
     *
     * @param  SchemaBuilderContext  $context
     * @param  mixed  $payload
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

    /**
     * @return string|null
     */
    private function getCommonNamespace(): ?string
    {
        $countStack = count($this->stack);
        $common = null;

        if ($countStack === 1) {
            $model = current($this->stack);

            return $model->inNamespace() ? $model->getNamespaceName() : null;
        } elseif ($countStack >= 2) {
            $common = null;

            for ($i = 1; $i < $countStack; $i++) {
                $stackItem1 = $this->stack[$i - 1];
                $stackItem2 = $this->stack[$i];

                if (!$stackItem1->inNamespace() || !$stackItem2->inNamespace()) {
                    $common = null;
                    break;
                }

                $stackItemsCommon = getCommonNamespace($stackItem1->getNamespaceName(), $stackItem2->getNamespaceName());

                if ($common) {
                    $common = getCommonNamespace($stackItemsCommon, $common);
                } else {
                    $common = $stackItemsCommon;
                }
            }
        }

        return $common;
    }

    /**
     * @inheritDoc
     */
    public function setSharedStore(SharedStore $store): void
    {
        $this->sharedStore = $store;
    }
}
