<?php

declare(strict_types=1);

namespace DMX\Support\Database\Eloquent\Models\Concerns;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * Trait HasSnakeCaseAttributes.
 *
 * @codeCoverageIgnore
 */
trait HasSnakeCaseAttributes
{
    use HasAttributes;

    /**
     * Get an attribute from the model incl. snake case notation support.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (empty($key)) {
            return null;
        }

        // performance: check if an eager loaded attribute exists with the given key, if yes use them
        if (array_key_exists($key, $this->relations ?? []) || method_exists($this, $key)) {
            return parent::getAttribute($key);
        }

        // check if the given key is set within the attributes or casts
        if (array_key_exists($key, $this->attributes ?? []) || array_key_exists($key, $this->casts ?? [])) {
            return parent::getAttribute($key);
        }

        // otherwise force key to snake case
        return parent::getAttribute(Str::snake($key));
    }

    /**
     * Set a given attribute on the model incl. snake case notation support.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        // check if there is a non snake_case attribute and uses it instead
        if (array_key_exists($key, $this->attributes ?? [])) {
            return parent::setAttribute(
                $key,
                $this->hasCast($key) ? $this->castAttribute($key, $value) : $value
            );
        }

        // otherwise force key to snake case
        $snakeKey = Str::snake($key);

        return parent::setAttribute(
            $snakeKey,
            $this->hasCast($snakeKey) ? $this->castAttribute($snakeKey, $value) : $value
        );
    }
}
