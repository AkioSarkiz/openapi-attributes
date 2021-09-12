<?php

namespace OpenApiGenerator\Tests\Examples\SimpleSchema;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Schema;
use OpenApiGenerator\Types\PropertyType;

#[
    Info('test'),
    Schema('personalDataSchema'),
    Property(PropertyType::STRING, 'name'),
    Property(PropertyType::STRING, 'phone'),
    Property(PropertyType::INT, 'age'),
]
class SimpleSchema
{
    //
}
