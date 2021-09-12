<?php

namespace OpenApiGenerator\Tests\Examples\SimpleSchema;

use OpenApiGenerator\Tests\BaseJsonSchemaTest;

class SimpleSchemaTest extends BaseJsonSchemaTest
{
    /**
     * @inheritDoc
     */
    protected function getClassesScan(): array
    {
        return [
            SimpleSchema::class,
        ];
    }
}
