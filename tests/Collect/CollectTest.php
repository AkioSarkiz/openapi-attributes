<?php

namespace OpenApiGenerator\Tests\Collect;

use OpenApiGenerator\Tests\BaseJsonSchemaTest;
use OpenApiGenerator\Tests\Collect\Http\Controllers\BookController;
use OpenApiGenerator\Tests\Collect\Http\Controllers\Controller;
use OpenApiGenerator\Tests\Collect\Http\Controllers\ListController;
use OpenApiGenerator\Tests\Collect\Http\Controllers\UserController;
use OpenApiGenerator\Tests\Collect\Http\Schemas\Book;
use OpenApiGenerator\Tests\Collect\Http\Schemas\User;
use OpenApiGenerator\Tests\Collect\Http\Schemas\Another\User as UserAlt;

// TODO
class CollectTest extends BaseJsonSchemaTest
{
    /**
     * @inheritDoc
     */
    protected function getClassesScan(): array
    {
        return [
            // controllers
            Controller::class,
//            ListController::class,
            BookController::class,
//            UserController::class,

            // schemas
            User::class,
            UserAlt::class,
            Book::class,
        ];
    }
}