<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests;

use OpenApiGenerator\Generator;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;
use ReflectionClass;
use ReflectionException;

abstract class BaseJsonSchemaTest extends TestCase
{
    private string $id;

    /**
     * @return array
     */
    abstract protected function getClassesScan(): array;

    /**
     * @exampel 'https://example.com/SimpleController.json'
     * @return string
     */
    protected function getId(): string
    {
        if (empty($this->id)) {
            $this->id ='https://example.com/' . uniqid();
        }

        return $this->id;
    }

    /**
     * @return string
     */
    protected function getDir(): string
    {
        try {
            return dirname((new ReflectionClass(get_class($this)))->getFileName());
        } catch (ReflectionException $e) {
            echo $e->getMessage();

            return '';
        }
    }

    /**
     * @return string
     */
    protected function getSchema(): string
    {
        return $this->getDir() . '/schema.json';
    }

    /**
     * @return string
     */
    protected function getOutPath(): string
    {
        return $this->getDir() . '/out.json';
    }

    public function test(): void
    {
        $validator = new Validator();

        $generator = Generator::create();

        foreach ($this->getClassesScan() as $class) {
            $generator->addScanClass($class);
        }

        $generator->generate();
        $validator->resolver()->registerFile($this->getId(), $this->getSchema());

        file_put_contents($this->getDir() . '/out.json', stripslashes(json_encode($generator->dataArray(), JSON_PRETTY_PRINT)));

        $result = $validator->validate($generator->dataStdClass(), $this->getId());

        if ($error = $result->error()) {
            $formatter = new ErrorFormatter();
            dump($formatter->formatOutput($error, 'verbose'));
            $this->fail();
        }

        $this->assertTrue($result->isValid());
    }
}
