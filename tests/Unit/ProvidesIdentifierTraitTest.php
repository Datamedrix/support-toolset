<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DMX\Support\Tests\Mocks\ProvidesIdentifierTraitMock;

class ProvidesIdentifierTraitTest extends TestCase
{
    /**
     * Test.
     */
    public function testMethodIdentifier()
    {
        $identifier = 'DummY-' . rand(100, 999) . '-' . date('Ymd_His') . '-' . rand(100000, 999999);
        $mockObj = new ProvidesIdentifierTraitMock($identifier);
        $this->assertEquals($identifier, $mockObj->identifier());
    }
}
