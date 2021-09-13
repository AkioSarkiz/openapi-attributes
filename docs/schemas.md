### Generation schemas

Package supported schemas openapi. For more details about schema see [documentation](https://swagger.io/specification/#schema-object).


#### Base example
For base schema need define properties attributes. This can be a bit tedious, but it gives you full control over your schema.
An alternative approach is to use ModelSchema.
```php
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
```

#### Model Schema
```php

#[Schema(model: true)]
class SchemaModel
{
    public string $name;
    public bool $is_banned;
    public float $price;

    // property can override type, name, format and add new info.
    #[
        Property(
            description: 'The age of person',
            example: 123,
            format: 'int32',
        ),
    ]
    public int $age;
}

```