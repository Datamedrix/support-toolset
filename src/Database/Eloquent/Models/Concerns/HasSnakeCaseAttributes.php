<?php

declare(strict_types=1);

namespace DMX\Support\Database\Eloquent\Models\Concerns;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Trait HasSnakeCaseAttributes.
 * When using this trait, the model is marked as having snake_case attributes and will automatically convert camelCase
 * or PascalCase attribute names to snake_case.
 *
 * Example:
 * ```php
 * $myAwesomeModel->first_name = 'John';
 * $myAwesomeModel->firstName = 'John';
 * $myAwesomeModel->setAttribute('fist_name', 'John');
 * $myAwesomeModel->setAttribute('fistName', 'John');
 * // all of the above will set the attribute 'first_name' to 'John'
 *
 * echo $myAwesomeModel->first_name;
 * echo $myAwesomeModel->firstName;
 * echo $myAwesomeModel->getAttribute('fist_name');
 * echo $myAwesomeModel->getAttribute('fistName');
 * // all of the above will return 'John'
 * ```
 *
 * @mixin EloquentModel
 *
 * @uses \Illuminate\Database\Eloquent\Concerns\HasAttributes
 */
trait HasSnakeCaseAttributes
{
    /**
     * Get an attribute from the model incl. camelCase and PascalCase notation support.
     * The key will attempt to be converted to snake_case if it does not exist in the attributes or casts.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute($key): mixed
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
     * Set a given attribute on the model incl. incl. camelCase and PascalCase notation support.
     * The key will attempt to be converted to snake_case if it does not exist in the attributes list before.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setAttribute($key, $value): self
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
