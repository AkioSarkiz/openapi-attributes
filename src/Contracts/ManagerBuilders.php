<?php

declare(strict_types=1);

namespace OpenApiGenerator\Contracts;

interface ManagerBuilders
{
    /**
     * @return string[]
     */
    public function getAvailableBuilders(): array;
}
