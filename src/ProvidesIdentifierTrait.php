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

namespace DMX\Support;

/**
 * Trait ProvidesIdentifierTrait.
 *
 * @deprecated Please use the DMX\Support\ProvidesIdentifier trait instead.
 */
trait ProvidesIdentifierTrait
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @return string
     */
    public function identifier(): string
    {
        return $this->identifier;
    }
}
