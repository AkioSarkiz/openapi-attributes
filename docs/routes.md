---
lang: en-US
title: Definition routes
---

#### Define simple routes

```php
use OpenApiGenerator\Attributes\Property\Str;

class SimpleController
{
    #[
        Get('/path', ['Dummy'], 'path'),
        Str('test'),
        
        Response(200, 'the description'),
    ]
    public function get(): void
    {
        //
    }
}
```
#### Define advanced routes
```php
use OpenApiGenerator\Attributes\Property\Number;
use OpenApiGenerator\Attributes\Property\Obj;
use OpenApiGenerator\Attributes\Property\Boolean;

class Controller
{
    #[
        Get('/path/{id}', ['Dummy'], 'Dummy path'),
        Number('id', description: 'id of dummy'),
        Obj('test', properties: [
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
        
        Response(200, 'the description'),
        Boolean('success'),
    ]
    public function get(float $id): void {
        //
    }
}

```

##### Response array

```php
use OpenApiGenerator\Attributes\Property\Str;
use OpenApiGenerator\Attributes\Property\Obj;
use OpenApiGenerator\Attributes\Property\Number;

class Controller
{
    #[
        Get('/path/{id}', ['Dummy'], 'Dummy path'),

        Response(200, type: 'array'),
        Obj(properties: [
            'name' => PropertyType::STRING,
            'password' => PropertyType::STRING,
            'age' => PropertyType::INT,
        ]),

        Response(400, type: 'array'),
        Str,

        Response(500, 'the description', type: 'array'),
        Number,
    ]
    public function get(float $id): void {
        //
    }
}
```
