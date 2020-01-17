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

namespace DMX\Support\Tests\Mocks;

use DMX\Support\ProvidesIdentifier;

class ProvidesIdentifierTraitMock
{
    use ProvidesIdentifier;

    /**
     * ProvidesIdentifierTraitMock constructor.
     */
    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }
}
