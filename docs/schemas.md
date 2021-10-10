---
lang: en-US
title: Definition schemas
---

### Generation schemas

Package supported schemas openapi. For more details about schema see [documentation](https://swagger.io/specification/#schema-object).


#### Base example
For base schema need define properties attributes. This can be a bit tedious, but it gives you full control over your schema.
An alternative approach is to use ModelSchema.
```php
use OpenApiGenerator\Attributes\Property\Str;
use OpenApiGenerator\Attributes\Property\Number;

#[
    Info('test'),
    Schema('personalDataSchema'),
    Str('name'),
    Str('phone'),
    Number('age'),
]
class SimpleSchema
{
    //
}
```

#### Model Schema

```php
use OpenApiGenerator\Attributes\Property\Number;
use OpenApiGenerator\Attributes\Schema\Model;

#[Schema(model: true)]
// or
#[Model]
class SchemaModel
{
    public string $title;
    public bool $is_banned;
    public float $price;

    // property can override type, name, format and add new info.
    #[Property(
        description: 'The age of person',
        example: 123,
        format: 'int32',
    )]
    public int $age;
    
    // or
    #[Number(
        description: 'The age of person',
        example: 123,
        format: 'int32',
    )]
    public $ageAlt;
}

```