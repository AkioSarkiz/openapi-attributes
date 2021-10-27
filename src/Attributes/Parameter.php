<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JetBrains\PhpStorm\ArrayShape;
use OpenApiGenerator\Contracts\Attribute as AttributeContract;

/**
 * Define parameter object.
 *
 * Represents a parameter (e.g. /route/{id} where id is the parameter).
 * A schema is automatically set to generate the parameter type.
 *
 * @see https://swagger.io/specification/#parameter-object.
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Parameter implements AttributeContract
{
    private array $schema = [];

    /**
     * @param  string  $name  The name of the parameter. Parameter names are case sensitive.
     *      If in is "path", the name field MUST correspond to a template expression occurring within the
     *      path field in the Paths Object. See Path Templating for further information.
     *      If in is "header" and the name field is "Accept", "Content-Type" or "Authorization", the parameter definition SHALL be ignored.
     *      For all other cases, the name corresponds to the parameter name used by the in property.
     *
     * @param  string  $type  The type of parameter.
     *
     * @param  string|null  $description  A brief description of the parameter. This could contain examples of use.
     *      CommonMark syntax MAY be used for rich text representation.
     *
     * @param  string  $in  The location of the parameter. Possible values are "query", "header", "path" or "cookie".
     *
     * @param  bool|null  $required  Determines whether this parameter is mandatory. If the parameter location is "path",
     *      this property is REQUIRED and its value MUST be true. Otherwise, the property MAY be included and
     *      its default value is false.
     *
     * @param  mixed|string  $example  Example of the parameter's potential value. The example SHOULD match
     *      the specified schema and encoding properties if present. The example field is mutually exclusive of
     *      the examples field. Furthermore, if referencing a schema that contains an example, the example value
     *      SHALL override the example provided by the schema. To represent examples of media types that cannot naturally
     *      be represented in JSON or YAML, a string value can contain the example with escaping where necessary.
     *
     * @param mixed $enum  You can restrict a parameter to a fixed set of values by adding the enum to the parameter’s schema.
     *      The enum values must be of the same type as the parameter data type.
     */
    public function __construct(
        private string $name,
        private string $type,
        private string $in = 'path',
        private ?string $description = null,
        private ?bool $required = null,
        private mixed $example = '',
        private mixed $format = '',
        private mixed $enum = null,
    ) {
        if ($in === 'path') {
            $this->required = true;
        }
    }

    #[ArrayShape([
        'name' => 'string',
        'in' => 'string',
        'schema' => 'array',
        'description' => 'string|null',
        'required' => 'bool|null'
    ])]
    public function jsonSerialize(): array
    {
        return removeEmptyValues([
            'name' => $this->name,
            'in' => $this->in,
            'schema' => $this->formatSchema(),
            'required' => $this->required,
            'description' => $this->description,
        ]);
    }

    /**
     * Format schema for serialize to json.
     *
     * @return array
     */
    private function formatSchema(): array
    {
        $schema = $this->schema;
        $schema['type'] = $this->type;
        $schema['format'] = $this->format ?? $schema['format'];
        $schema['example'] = $this->example;
        $schema['enum'] = $this->enum;

        return removeEmptyValues($schema);
    }
}
