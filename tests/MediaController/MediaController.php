<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests\MediaController;

use OpenApiGenerator\Attributes\Info;
use OpenApiGenerator\Attributes\Property;
use OpenApiGenerator\Attributes\Property\File;
use OpenApiGenerator\Attributes\Response;
use OpenApiGenerator\Attributes\Route\Post;
use OpenApiGenerator\Types\PropertyType;

#[
    Info('MediaController')
]
class MediaController
{
    #[
        Post('media/upload', contentType: 'multipart/form-data'),
        File('file'),

        Response(200, 'test', contentType: 'image/png'),
        File('file_response_success'),

        Response(403, description: 'fail', contentType: 'image/jpg'),
        File('file_response_fail'),
    ]
    public function upload(): void
    {
        //
    }
}