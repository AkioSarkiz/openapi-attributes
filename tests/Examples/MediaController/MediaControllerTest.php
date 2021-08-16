<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\MediaController;

use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Generator;
use OpenApiGenerator\Tests\Examples\SimpleController\SimpleController;
use OpenApiGenerator\Tests\TestCase;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;

class MediaControllerTest extends TestCase
{
    public function test(): void
    {
        $this->markTestSkipped();
        return;

        $validator = new Validator();
        $generator = Generator::create()
            ->addScanClass(MediaController::class)
            ->generate();

        file_put_contents(__DIR__. '/out.json', $generator->dataJson());
        exit();

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