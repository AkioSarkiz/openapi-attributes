<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\Controller;

use OpenApiGenerator\Generator;
use OpenApiGenerator\Tests\BaseJsonSchemaTest;
use OpenApiGenerator\Tests\TestCase;
use Opis\JsonSchema\{Errors\ErrorFormatter, Validator,};

class ControllerTest extends BaseJsonSchemaTest
{
    /**
     * @inheritDoc
     */
    protected function getClassesScan(): array
    {
        return [
            Controller::class,
        ];
    }
}
