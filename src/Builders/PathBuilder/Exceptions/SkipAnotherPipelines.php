<?php

namespace OpenApiGenerator\Builders\PathBuilder\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

/**
 * Class SkipAnotherPipelines - using only in builder. Must never thrown in package.
 * @package OpenApiGenerator\Builders\Utils\Exceptions
 */
class SkipAnotherPipelines extends Exception
{
    #[Pure]
    public function __construct()
    {
        parent::__construct();
    }
}