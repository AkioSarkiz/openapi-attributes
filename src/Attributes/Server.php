<?php

declare(strict_types=1);

namespace OpenApiGenerator\Attributes;

use Attribute;
use JsonSerializable;

/**
 * Define server item.
 *
 * @see https://swagger.io/specification/#server-object
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Server implements JsonSerializable
{
    /**
     * @param  string  $url  A URL to the target host.
     *      This URL supports Server Variables and MAY be relative,
     *      to indicate that the host location is relative to the location where the OpenAPI document is being served.
     *      Variable substitutions will be made when a variable is named in {brackets}.
     *
     * @param  string  $description  An optional string describing the host designated by the URL.
     *      CommonMark syntax MAY be used for rich text representation.
     */
    public function __construct(
        private string $url,
        private string $description = '',
    ) {
        //
    }

    public function jsonSerialize(): array
    {
        $data = [
            'url' => $this->url,
            'description' => $this->description,
        ];

        return removeEmptyValues($data);
    }
}
