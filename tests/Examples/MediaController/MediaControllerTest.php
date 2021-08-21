<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\MediaController;

use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Generator;
use OpenApiGenerator\Tests\BaseJsonSchemaTest;
use OpenApiGenerator\Tests\Examples\SimpleController\SimpleController;
use OpenApiGenerator\Tests\TestCase;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;

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