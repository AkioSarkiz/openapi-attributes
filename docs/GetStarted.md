### Get started

#### 1 step: installation
via composer
```bash
composer require akiosarkiz/openpapi-attributes
```

#### 2 step: use attributes
Write documentation for your code. For example, simple controller:
```php
use OpenApiGenerator\Attributes\Parameter;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;

class SimpleController 
{
    #[
        Get('users/{id}'),
        Response(200)
    ]    
    public function show(
        #[Parameter] int $id
    ): void {
        //
    }
}
```

#### 3 step: create script & run
 Run script.
```bash
php ./vendor/bin/generate-openapi.php ./tests/Examples/Controller/ .
```

----
