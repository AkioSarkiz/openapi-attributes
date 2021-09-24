<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\SchemaModel;

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