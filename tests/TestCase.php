<?php

declare(strict_types=1);

namespace OpenApiGenerator\Tests;

use PHPUnit\Framework\TestCase as BaseTest;

class TestCase extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();

        // add custom up script
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // add custom down script
    }
}
