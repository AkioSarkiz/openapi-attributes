<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\ResponseArrayItems;

use OpenApiGenerator\Tests\BaseJsonSchemaTest;

class ResponseArrayItemsTest extends BaseJsonSchemaTest
{
    /**
     * @inheritDoc
     */
    protected function getClassesScan(): array
    {
        return [
            ResponseArrayItems::class,
        ];
    }
}
