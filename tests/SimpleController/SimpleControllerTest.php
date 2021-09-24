<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\SimpleController;

use OpenApiGenerator\Tests\BaseJsonSchemaTest;

class SimpleControllerTest extends BaseJsonSchemaTest
{
    /**
     * @inheritDoc
     */
    public function getClassesScan(): array
    {
        return [
            SimpleController::class,
        ];
    }
}
