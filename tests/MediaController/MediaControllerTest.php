<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\MediaController;

use OpenApiGenerator\Tests\BaseJsonSchemaTest;

class MediaControllerTest extends BaseJsonSchemaTest
{
    /**
     * @inheritDoc
     */
    protected function getClassesScan(): array
    {
        return [
            MediaController::class
        ];
    }
}