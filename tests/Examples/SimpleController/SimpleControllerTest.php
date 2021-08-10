<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\SimpleController;

use OpenApiGenerator\Generator;
use Opis\JsonSchema\{Errors\ErrorFormatter, Validator,};
use PHPUnit\Framework\TestCase;

class SimpleControllerTest extends TestCase
{
    public function test(): void
    {
        $validator = new Validator();
        $generator = Generator::create()
            ->addScanClass(SimpleController::class)
            ->generate();

        $validator->resolver()->registerFile(
            'https://example.com/SimpleController.json',
            __DIR__ . '/schema.json',
        );

        $result = $validator->validate($generator->dataStdClass(), 'https://example.com/SimpleController.json');

        if ($error = $result->error()) {
            $formatter = new ErrorFormatter();
            dump($formatter->formatOutput($error, 'verbose'));
            $this->fail();
        }

        $this->assertTrue($result->isValid());
    }
}
