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
Copy `generate.php` from current repository to your project. Run script.
```bash
php ./generate.php ./tests/Examples/Controller/ .
```

----
