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
        Post('media/upload', contentType: 'multipart/form-data'),
        Property('file', Property::FILE),

        Response(200, contentType: 'image/png'),
        Property('file_response_success', Property::FILE),

        Response(403, description: 'fail', contentType: 'image/jpg'),
        Property('file_response_fail', Property::FILE),
    ]
    public function upload(): void
    {
        //
    }
}