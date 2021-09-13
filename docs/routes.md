---
lang: en-US
title: Definition routes
---

TODO: update documentation

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