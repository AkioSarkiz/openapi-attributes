<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * Define info object.
 *
 * The object provides metadata about the API. The metadata MAY be used by the clients if needed, and
 * MAY be presented in editing or documentation generation tools for convenience.
 *
 * @see https://swagger.io/specification/#info-object
 */
#[Attribute(Attribute::TARGET_CLASS)]
class Info implements JsonSerializable
{
    /**
     * Info constructor.
     *
     * @param  string  $title  The title of the API.
     *
     * @param  string  $version  The version of the OpenAPI document (which is distinct from the OpenAPI
     *      Specification version or the API implementation version).
     *
     * @param  string|null  $description  A short description of the API. CommonMark syntax MAY be used for rich text representation.
     * @param  string|null  $termsOfService  A URL to the Terms of Service for the API. MUST be in the format of a URL.
     * @param  array|null  $contact  The contact information for the exposed API. (@see https://swagger.io/specification/#contact-object)
     * @param  array|null  $license  The license information for the exposed API. (@see https://swagger.io/specification/#license-object)
     */
    public function __construct(
        private string $title,
        private string $version = '1.0.0',
        private ?string $description = null,
        private ?string $termsOfService = null,
        private ?array $contact = null,
        private ?array $license = null,
    ) {
        //
    }

    #[ArrayShape([
        'title' => 'string',
        'version' => 'string',
        'summary' => 'string',
        'description' => 'string'
    ])]
    public function jsonSerialize(): array
    {
        return removeEmptyValues([
            'title' => $this->title,
            'version' => $this->version,
            'description' => $this->description,
            'termsOfService' => $this->termsOfService,
            'contact' => $this->contact,
            'license' => $this->license,
        ]);
    }
}
