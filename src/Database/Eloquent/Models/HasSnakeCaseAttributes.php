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

namespace DMX\Support\Database\Eloquent\Models;

/**
 * Trait HasSnakeCaseAttributes.
 *
 * @codeCoverageIgnore
 */
trait HasSnakeCaseAttributes
{
    /**
     * Get an attribute from the model.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        // performance: check if a eager loaded attribute exists with the given key, if yes use them
        if (array_key_exists($key, $this->relations ?? [])) {
            return parent::getAttribute($key);
        }

        // otherwise force key to snake case
        return parent::getAttribute(snake_case($key));
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }
}
