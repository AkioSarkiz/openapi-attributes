<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\SchemaModel;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Schema;
use OpenApiGenerator\Tests\BaseJsonSchemaTest;

class SchemaModelTest extends BaseJsonSchemaTest
{
    /**
     * @inheritDoc
     */
    protected function getClassesScan(): array
    {
        return [
            SchemaModel::class,
        ];
    }
}