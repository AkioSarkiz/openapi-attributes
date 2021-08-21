<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JsonSerializable;

/**
 * Define path object.
 *
 * @see https://swagger.io/specification/#paths-object
 */
#[Attribute]
class Route implements JsonSerializable
{
    public const GET = 'get';
    public const POST = 'post';
    public const PATCH = 'patch';
    public const PUT = 'put';
    public const DELETE = 'delete';

    private array $getParams = [];
    private ?Response $response = null;
    private ?RequestBody $requestBody = null;

    public function __construct(
        private string $method,
        private string $route,
        private array $tags = [],
        private string $summary = '',
        private string $description = '',
        private mixed $security = null,
        private string $contentType = 'application/json',
    ){
        //
    }

    public function addParam(Parameter $params): void
    {
        $this->getParams[] = $params;
    }

    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getGetParams(): array
    {
        return $this->getParams;
    }

    public function setGetParams(array $getParams): void
    {
        // Just check if it's an array of GetParam and add it
        array_walk(
            $getParams,
            function (array $params) {
                array_walk($params, fn(Parameter $param) => $this->getParams[] = $param);
            }
        );
    }

    public function jsonSerialize(): array
    {
        $array = [];
        $array[$this->getRoute()][$this->method] = [];

        if ($this->tags) {
            $array[$this->getRoute()][$this->method]['tags'] = $this->tags;
        }

        if ($this->summary) {
            $array[$this->getRoute()][$this->method]['summary'] = $this->summary;
        }

        if (count($this->getParams) > 0) {
            $array[$this->getRoute()][$this->method]['parameters'] = $this->getParams;
        }

        if ($this->requestBody && !$this->requestBody->empty()) {
            $array[$this->getRoute()][$this->method]['requestBody'] = $this->requestBody;
        }

        if ($this->response) {
            $array[$this->getRoute()][$this->method]['responses'] = $this->response;
        }

        if ($this->description) {
            $array[$this->getRoute()][$this->method]['description'] = $this->description;
        }

        if ($this->security) {
            $array[$this->getRoute()][$this->method]['security'] = $this->security;
        }

        return $array;
    }

    public function getRoute(): string
    {
        // all routes must starting with /.
        return substr($this->route, 0, 1) !== '/' ? '/' . $this->route : $this->route;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }
}