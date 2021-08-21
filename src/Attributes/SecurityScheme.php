<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JsonSerializable;

/**
 * Define security schema.
 *
 * @see https://swagger.io/specification/#security-scheme-object
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class SecurityScheme implements JsonSerializable
{
    /**
     * SecurityScheme constructor.
     *
     * @param string $securityKey Unique security key.
     * @param string $type The type of the security scheme. Valid values are "apiKey", "http", "oauth2", "openIdConnect".
     * @param string $name The name of the header, query or cookie parameter to be used.
     * @param string $in The location of the API key. Valid values are "query", "header" or "cookie".
     * @param string $scheme The name of the HTTP Authorization scheme to be used in the Authorization header as defined in RFC7235.
     *      The values used SHOULD be registered in the IANA Authentication Scheme registry.
     * @param string $description A short description for security scheme. CommonMark syntax MAY be used for rich text representation.
     * @param string $bearerFormat A hint to the client to identify how the bearer token is formatted.
     *      Bearer tokens are usually generated by an authorization server, so this information is primarily for documentation purposes.
     */
    public function __construct(
        private string $securityKey,
        private string $type,
        private string $name,
        private string $in,
        private string $scheme,
        private string $bearerFormat = '',
        private string $description = '',
    )
    {
        //
    }

    public function jsonSerialize(): array
    {
        $data = [
            'securityKey' => $this->securityKey,
            'type' => $this->type,
            'name' => $this->name,
            'in' => $this->in,
            'scheme' => $this->scheme,
            'description' => $this->description,
            'bearerFormat' => $this->bearerFormat,
        ];

        return removeEmptyValues($data);
    }
}