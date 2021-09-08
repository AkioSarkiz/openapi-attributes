<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\Examples\MediaController;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Types\PropertyType;

#[Info('test')]
class MediaController
{
    #[
        Post('media/upload', contentType: 'multipart/form-data'),
        Property(PropertyType::FILE, 'file'),

        Response(200, contentType: 'image/png'),
        Property(PropertyType::FILE, 'file_response_success'),

        Response(403, description: 'fail', contentType: 'image/jpg'),
        Property(PropertyType::FILE, 'file_response_fail'),
    ]
    public function upload(): void
    {
        //
    }
}