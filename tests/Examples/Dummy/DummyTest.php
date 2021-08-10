<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\Dummy;

use OpenApiGenerator\Generator;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;
use PHPUnit\Framework\TestCase;

class DummyTest extends TestCase
{
    public function test(): void
    {
        $validator = new Validator();
        $generator = Generator::create()
            ->addScanClass([
                DummyComponent::class,
                DummyController::class,
                DummyRefComponent::class,
            ])
            ->generate();

        $validator->resolver()->registerFile(
            'https://example.com/DummyComponent.json',
            __DIR__ . '/schema.json',
        );

        $result = $validator->validate($generator->dataStdClass(), 'https://example.com/DummyComponent.json');

        if ($error = $result->error()) {
            $formatter = new ErrorFormatter();
            dump($formatter->formatOutput($error, 'verbose'));
            $this->fail();
        }

        $this->assertTrue($result->isValid());
    }
}