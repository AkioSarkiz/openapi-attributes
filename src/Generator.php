<?php

declare(strict_types=1);

namespace OpenApiGenerator;

use JetBrains\PhpStorm\Pure;
use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Schema;
use OpenApiGenerator\Attributes\SecurityScheme;
use OpenApiGenerator\Attributes\Server;
use OpenApiGenerator\Exceptions\GeneratorException;
use OpenApiGenerator\Exceptions\OpenapiException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use stdClass;
use Symfony\Component\Yaml\Yaml;

class Generator
{
    public const OPENAPI_VERSION = '3.0.0';

    /**
     * For testing. If array is not empty, then generator use it.
     *
     * @var array
     */
    private array $classesScan = [];

    /**
     * API description
     *
     * @var array
     */
    private array $description = [];

    public function __construct(
        private GeneratorHttp $generatorHttp,
        private GeneratorSchemas $generatorSchemas,
    ){
    }

    /**
     * Create object with using package dependencies.
     *
     * @return Generator
     */
    #[Pure]
    public static function create(): Generator
    {
        return new self(new GeneratorHttp(), new GeneratorSchemas());
    }

    /**
     * Start point of the Open Api generator.
     *
     * Execution plan: get classes from directory, find controllers, schemas, get Attributes,
     * add each attribute to some sort of tree then transform it to a json file
     *
     * @throws OpenApiException
     */
    public function generate(): self
    {
        $classes = count($this->classesScan) ? $this->classesScan : get_declared_classes();

        foreach ($classes as $class) {
            try {
                $reflectionClass = new ReflectionClass($class);
            } catch (ReflectionException $e) {
                echo '[Warning] ReflectionException ' . $e->getMessage();

                continue;
            }

            $this->loadInfo($reflectionClass);
            $this->loadController($reflectionClass);
            $this->loadSchema($reflectionClass);
            $this->loadServer($reflectionClass);
            $this->loadSchemaSecurity($reflectionClass);
        }

        $this->description['paths'] = $this->generatorHttp->build();
        $this->description['components']['schemas'] = $this->generatorSchemas->build();

        return $this;
    }

    /**
     * Info OA which is the head of the file.
     *
     * @param ReflectionClass $reflectionClass
     * @return void
     */
    private function loadInfo(ReflectionClass $reflectionClass): void
    {
        if ($infos = $reflectionClass->getAttributes(Info::class, ReflectionAttribute::IS_INSTANCEOF)) {
            $this->description['info'] = $infos[0]->newInstance();
        }
    }

    /**
     * A controller with routes, call the HTTP Generator.
     *
     * @param ReflectionClass $reflectionClass
     * @return void
     */
    private function loadController(ReflectionClass $reflectionClass): void
    {
        $this->generatorHttp->append($reflectionClass);
    }

    /**
     * A schema (often a model), call the Schema Generator.
     *
     * @param ReflectionClass $reflectionClass
     * @return void
     */
    private function loadSchema(ReflectionClass $reflectionClass): void
    {
        if (count($reflectionClass->getAttributes(Schema::class))) {
            $this->generatorSchemas->append($reflectionClass);
        }
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return void
     */
    private function loadServer(ReflectionClass $reflectionClass): void
    {
        if (count($reflectionClass->getAttributes(Server::class))) {
            $serverAttributes = $reflectionClass->getAttributes(Server::class);

            foreach ($serverAttributes as $item) {
                $this->description['servers'][] = $item->newInstance();
            }
        }
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return void
     * @throws GeneratorException
     */
    private function loadSchemaSecurity(ReflectionClass $reflectionClass): void
    {
        if (count($reflectionClass->getAttributes(SecurityScheme::class))) {
            $securitySchemas = $reflectionClass->getAttributes(SecurityScheme::class);

            foreach ($securitySchemas as $item) {
                $data = $item->newInstance()->jsonSerialize();
                $key = $data['securityKey'];
                unset($data['securityKey']);

                if (isset($this->description['components']['securitySchemes'])
                    && array_key_exists($key, $this->description['components']['securitySchemes'])) {
                    throw GeneratorException::duplicateSchemaName($key);
                }

                $this->description['components']['securitySchemes'][$key] = $data;
            }
        }
    }

    /**
     * Array containing the entire API description.
     */
    public function dataArray(): array
    {
        $definition = [
            'openapi' => self::OPENAPI_VERSION,
            'info' => $this->description['info'],
            'servers' => $this->description['servers'] ?? [],
            'paths' => $this->description['paths'],
            'components' => $this->description['components'],
        ];

        ValidatorSchema::check($definition);

        return $definition;
    }

    /**
     * stdClass containing the entire API description.
     */
    public function dataStdClass(): stdClass
    {
        return json_decode(json_encode($this->dataArray()));
    }

    /**
     * Json containing the entire API description.
     */
    public function dataJson(): string
    {
        return json_encode($this->dataArray());
    }

    /**
     * Yaml containing the entire API description.
     */
    public function dataYaml(): string
    {
        return Yaml::dump($this->dataArray());
    }

    /**
     * Add class to scanning.
     * WARNING! it's method only for testing.
     *
     * @param string|string[] $classes
     * @return self
     */
    public function addScanClass(string|array $classes): self
    {
        $classes = is_array($classes) ? $classes : [$classes];

        foreach ($classes as $class) {
            $this->classesScan[] = $class;
        }

        return $this;
    }
}
