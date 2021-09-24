<?php

namespace OpenApiGenerator\Tests\RequestBodyArrayItems;

use OpenApiGenerator\Tests\BaseJsonSchemaTest;

class RequestBodyArrayItemsControllerTest extends BaseJsonSchemaTest
{
    /**
     * @inheritDoc
     */
    protected function getClassesScan(): array
    {
        return [
            RequestBodyArrayItemsController::class,
        ];
    }
}
