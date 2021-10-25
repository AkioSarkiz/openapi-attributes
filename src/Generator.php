<?php

declare(strict_types=1);

namespace OpenApiGenerator;

use JetBrains\PhpStorm\Pure;
use OpenApiGenerator\Builders\SharedStore;
use OpenApiGenerator\Contracts\Builder;
use OpenApiGenerator\Contracts\ManagerBuilders as ManagerBuildersContract;
use OpenApiGenerator\Exceptions\OpenapiException;
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
        private ManagerBuildersContract $managerBuilders
    ) {
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
        $sharedStore = new SharedStore();
        $buildersClasses = $this->managerBuilders->getAvailableBuilders();
        $buildersInstances = $this->generateBuildersInstances($buildersClasses, $sharedStore);

        $this->runBootBuilders($buildersInstances);
        $this->runBuildBuilders($buildersInstances);

        return $this;
    }

    /**
     * @param  array  $buildersInstances
     * @return void
     * @throws OpenapiException
     */
    private function runBuildBuilders(array $buildersInstances): void
    {
        /** @var Builder $builder */
        foreach ($buildersInstances as $builder) {
            $buildData = $builder->build();

            if (count($buildData)) {
                $this->set($buildData['key'], $buildData['data']);
            }
        }
    }

    /**
     * @param  array  $buildersInstances
     * @return void
     */
    private function runBootBuilders(array $buildersInstances): void
    {
        $classes = count($this->classesScan) ? $this->classesScan : get_declared_classes();

        /** @var Builder $builder */
        foreach($buildersInstances as $builder) {
            foreach ($classes as $class) {
                try {
                    $builder->append(new ReflectionClass($class));
                } catch (ReflectionException) {
                    echo 'Error reflection class: '.$class;
                }
            }

            $builder->boot();
        }
    }

    /**
     * @param  array  $builderClasses
     * @param  SharedStore  $sharedStore
     * @return array
     */
    private function generateBuildersInstances(array $builderClasses, SharedStore $sharedStore): array
    {
        $instances = [];

        // initialization builders.
        foreach ($builderClasses as $builder) {
            /** @var Builder $builder */
            $builderInstance = new $builder();
            $builderInstance->setSharedStore($sharedStore);
            $instances[] = $builderInstance;
        }

        return $instances;
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
     * @param  string|string[]  $classes
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
     * @param  string  $key
     * @param  array  $data
     */
    private function set(string $key, mixed $data): void
    {
        $formatArray = [];
        setArrayByPath($formatArray, $key, $data);
        $this->generated = array_merge_recursive($this->generated, $formatArray);
    }
}
