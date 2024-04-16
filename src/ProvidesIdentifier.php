<?php

declare(strict_types=1);

namespace DMX\Support;

trait ProvidesIdentifier
{
    /**
     * @var string
     */
    protected string $identifier;

    /**
     * @return string
     */
    public function identifier(): string
    {
        return $this->identifier ?? '';
    }
}
