<?php

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
