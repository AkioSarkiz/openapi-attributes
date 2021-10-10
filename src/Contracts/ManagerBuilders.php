<?php

declare(strict_types=1);

namespace OpenApiGenerator\Contracts;

interface ManagerBuilders
{
    /**
     * @return Builder[]
     */
    public function getAvailableBuilders(): array;
}
