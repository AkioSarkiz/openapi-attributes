<?php

namespace OpenApiGenerator\Builders\PathBuilder\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

/**
 * Class using only in builder. Must never throw in package.
 */
class SkipAnotherPipelines extends Exception
{
    #[Pure]
    public function __construct()
    {
        parent::__construct();
    }
}
