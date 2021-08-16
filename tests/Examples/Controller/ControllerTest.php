<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\Controller;

use OpenApiGenerator\Generator;
use OpenApiGenerator\Tests\TestCase;
use Opis\JsonSchema\{Errors\ErrorFormatter, Validator,};

class ControllerTest extends TestCase
{
    public function test(): void
    {
        $validator = new Validator();
        $generator = Generator::create()
            ->addScanClass(Controller::class)
            ->generate();

        $validator->resolver()->registerFile(
            'https://example.com/Controller.json',
            __DIR__ . '/schema.json',
        );

        $result = $validator->validate($generator->dataStdClass(), 'https://example.com/Controller.json');

        if ($error = $result->error()) {
            $formatter = new ErrorFormatter();
            dump($formatter->formatOutput($error, 'verbose'));
            $this->fail();
        }

        $this->assertTrue($result->isValid());
    }
}
