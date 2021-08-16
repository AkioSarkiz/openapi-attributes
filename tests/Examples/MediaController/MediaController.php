<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\MediaController;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Post;

#[Info('test')]
class MediaController
{
    #[
        Post('media/upload'),
        Property('file', Property::FILE),
        Response(200),
    ]
    public function upload(): void
    {
        //
    }
}