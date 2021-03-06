<?php

namespace OpenApiGenerator\Tests\SimpleSchema;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Schema;
use OpenApiGenerator\Types\PropertyType;

#[
    Info('SimpleSchema'),

    Schema('personalDataSchema'),
    Property(PropertyType::STRING, 'name'),
    Property(PropertyType::STRING, 'phone'),
    Property(PropertyType::INT, 'age'),
]
class SimpleSchema
{
    //
}
