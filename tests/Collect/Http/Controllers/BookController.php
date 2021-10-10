<?php

namespace OpenApiGenerator\Tests\Collect\Http\Controllers;

use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Tests\Collect\Http\Schemas\Book;
use OpenApiGenerator\Types\SchemaType;

class BookController extends Controller
{
    #[
        Get('books'),

        Response(200, 'get list books', type: SchemaType::ARRAY),
        Property(ref: Book::class)
    ]
    public function getList(): void
    {

    }
}