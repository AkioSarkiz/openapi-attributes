---
lang: en-US
title: Definition routes
---

#### Define simple routes

```php
class SimpleController
{
    #[
        Get('/path', ['Dummy'], 'path'),
        Property(PropertyType::STRING, 'test'),
        
        Response(200),
    ]
    public function get(): void
    {
        //
    }
}
```
#### Define advanced routes
```php
class Controller
{
    #[
        Get('/path/{id}', ['Dummy'], 'Dummy path'),
        Parameter('id', 'integer', description: 'id of dummy'),
        Property(PropertyType::OBJECT, 'test', properties: [
            'data' => PropertyType::STRING,
            'item' => [
                'type' => PropertyType::STRING,
            ],
            'anotherObject' => [
                'type' => PropertyType::OBJECT,
                'properties' => [
                    'output.json' => PropertyType::STRING,
                ],
            ],
        ]),
        
        Response(200),
        Property(PropertyType::BOOLEAN, 'success'),
    ]
    public function get(float $id): void {
        //
    }
}

```

##### Response array

```php
class Controller
{
    #[
        Get('/path/{id}', ['Dummy'], 'Dummy path'),

        Response(200, type: 'array'),
        Property(PropertyType::OBJECT, properties: [
            'name' => PropertyType::STRING,
            'password' => PropertyType::STRING,
            'age' => PropertyType::INT,
        ]),

        Response(400, type: 'array'),
        Property(PropertyType::STRING),

        Response(500, type: 'array'),
        Property(PropertyType::INT),
    ]
    public function get(float $id): void {
        //
    }
}
```
