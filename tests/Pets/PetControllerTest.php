<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Pets;

use OpenApiGenerator\Tests\BaseJsonSchemaTest;

class PetControllerTest extends BaseJsonSchemaTest
{
    /**
     * @inheritDoc
     */
    protected function getClassesScan(): array
    {
        return [
            PetController::class,
        ];
    }
}
