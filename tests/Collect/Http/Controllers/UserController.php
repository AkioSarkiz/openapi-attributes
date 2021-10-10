<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Collect\Http\Controllers;

use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Get;
use OpenApiGenerator\Tests\Collect\Http\Schemas\User;
use OpenApiGenerator\Tests\Collect\Http\Schemas\Another\User as AltUser;
use OpenApiGenerator\Types\SchemaType;

class UserController extends Controller
{
    #[
        Get('users'),

        Response(200, 'Get users', type: SchemaType::ARRAY),
        Property(ref: AltUser::class),

        Response(201, 'Get users', type: SchemaType::ARRAY),
        Property(ref: '#/components/schemas/Another_User'), // by original class name
    ]
    public function getList()
    {
        //
    }

    #[
        Get('users_alt'),

        Response(200, 'Get alternative users', type: SchemaType::ARRAY),
        Property(ref: User::class),

        Response(201, 'Get alternative users', type: SchemaType::ARRAY),
        Property(ref: '#/components/schemas/User'),
    ]
    public function getAnotherList()
    {
        //
    }
}
