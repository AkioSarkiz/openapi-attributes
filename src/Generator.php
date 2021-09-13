<?php

declare(strict_types=1);

namespace OpenApiGenerator;

use JetBrains\PhpStorm\Pure;
use OpenApiGenerator\Exceptions\OpenapiException;
use OpenApiGenerator\Interfaces\BuilderInterface;
use ReflectionClass;
use ReflectionException;
use stdClass;
use Symfony\Component\Yaml\Yaml;

class Generator
{
    public const OPENAPI_VERSION = '3.0.0';

    /**
     * If array is not empty, then generator use only it.
     *
     * @var array
     */
    private array $classesScan = [];

    /**
     * Data generated.
     *
     * @var array
     */
    private array $generated = [
        'openapi' => self::OPENAPI_VERSION,
    ];

    public function __construct(
        private ManagerBuilders $managerBuilders
    )
    {
        //
    }

    /**
     * Create object with using package dependencies.
     *
     * @return Generator
     */
    #[Pure]
    public static function create(): Generator
    {
        return new self(new ManagerBuilders());
    }

    /**
     * Generate OpenApi schema.
     * After this you can access data in methods: dataJson, dataArray, dataYaml, dataStdClass.
     *
     * @throws OpenApiException
     */
    public function generate(): self
    {
        $classes = count($this->classesScan) ? $this->classesScan : get_declared_classes();
        $builders = $this->managerBuilders->getAvailableBuilders();

        /** @var BuilderInterface $builder */
        foreach ($builders as $builder) {
            $builder = new $builder();

            foreach ($classes as $class) {
                try {
                    $builder->append(new ReflectionClass($class));
                } catch (ReflectionException) {
                    echo 'Error reflection class: ' . $class;
                }
            }

            $buildData = $builder->build();
            $this->set($buildData['key'], $buildData['data']);
        }

        return $this;
    }

    /**
     * Export generated data as array.
     *
     * @see Generator::generate()
     */
    public function dataArray(): array
    {
        return $this->generated;
    }

    /**
     * Export generated data as stdClass.
     *
     * @see Generator::generate()
     */
    public function dataStdClass(): stdClass
    {
        return json_decode(json_encode($this->dataArray()));
    }

    /**
     * Export generated data as json.
     *
     * @see Generator::generate()
     */
    public function dataJson(): string
    {
        return json_encode($this->dataArray());
    }

    /**
     * Export generated data as yaml.
     *
     * @see Generator::generate()
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

    /**
     * Set generated key => value. Supported dots keys.
     *
     * @param string $key
     * @param array $data
     */
    private function set(string $key, array $data): void
    {
        $formatArray = [];
        setArrayByPath($formatArray, $key, $data);
        $this->generated = array_merge_recursive($this->generated, $formatArray);
    }
}
