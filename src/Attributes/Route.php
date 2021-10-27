<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use OpenApiGenerator\Contracts\Attribute as AttributeContract;
use OpenApiGenerator\Types\SchemaType;

/**
 * Define path object.
 *
 * @see https://swagger.io/specification/#paths-object
 */
#[Attribute(Attribute::TARGET_METHOD)]
class Route implements AttributeContract
{
    public const GET = 'get';
    public const POST = 'post';
    public const PATCH = 'patch';
    public const PUT = 'put';
    public const DELETE = 'delete';

    /**
     * Create new instance route.
     *
     * @param  string  $method  Http method.
     * @param  string  $route  Http path.
     *
     * @param  array  $tags  A list of tags for API documentation control.
     *      Tags can be used for logical grouping of operations by resources or any other qualifier.
     *
     * @param  string  $summary  A short summary of what the operation does.
     *
     * @param  string  $description  A verbose explanation of the operation behavior.
     *      CommonMark syntax MAY be used for rich text representation.
     *
     * @param  mixed|null  $security  A declaration of which security mechanisms can be used for this operation.
     *      The list of values includes alternative security requirement objects that can be used.
     *      Only one of the security requirement objects need to be satisfied to authorize a request.
     *      To make security optional, an empty security requirement ({}) can be included in the array.
     *      This definition overrides any declared top-level security.
     *      To remove a top-level security declaration, an empty array can be used.
     *
     * @param  string  $contentType  Http content type. By default application/json.
     *
     * @param  string  $schemaType
     *
     * @param  array  $required
     */
    public function __construct(
        private string $method,
        private string $route,
        private array $tags = [],
        private string $summary = '',
        private string $description = '',
        private mixed $security = null,
        private string $contentType = 'application/json',
        private string $schemaType = SchemaType::OBJECT,
        private array $required = [],
    ) {
        //
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getSchemaType(): string
    {
        return $this->schemaType;
    }

    public function getSchemaTypeKey(): string
    {
        return $this->schemaType === SchemaType::OBJECT ? 'properties' : 'items';
    }

    public function jsonSerialize(): array
    {
        $array = [];
        $array[$this->getRoute()][$this->method] = [];
        $route = &$array[$this->getRoute()][$this->method];

        if ($this->security) {
            if (is_string($this->security)) {
                $guards = explode('|', $this->security);
                $this->security = [];

                foreach($guards as $guard) {
                    $this->security[][$guard] = [];
                }
            }
        }

        foreach (['tags', 'summary', 'description', 'security'] as $prop) {
            $value = $this->$prop;

            if ($value !== null) {
                $route[$prop] = $value;
            }
        }

        return $array;
    }

    public function getRoute(): string
    {
        // all routes must start with /.
        return substr($this->route, 0, 1) !== '/' ? '/'.$this->route : $this->route;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function getRequired(): array
    {
        return $this->required;
    }
}
