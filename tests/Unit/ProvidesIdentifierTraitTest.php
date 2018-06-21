<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2018 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author Christian Graf <c.graf@datamedrix.com>
 */

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
