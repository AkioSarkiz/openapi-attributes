<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\Pets;

use OpenApiGenerator\Generator;
use OpenApiGenerator\Tests\Examples\SimpleController\SimpleController;
use OpenApiGenerator\Tests\TestCase;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;

class PetControllerTest extends TestCase
{
    public function test(): void
    {
        $validator = new Validator();
        $generator = Generator::create()
            ->addScanClass(PetController::class)
            ->generate();

        file_put_contents(__DIR__.'/out.json', json_encode($generator->dataArray(), JSON_PRETTY_PRINT));
        dd();

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
