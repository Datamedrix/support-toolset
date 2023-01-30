<?php

declare(strict_types=1);

namespace DMX\Support\Database\Eloquent\Models\Concerns;

trait CanBeFilledByArray
{
    /**
     * Fill attributes of a model object with an associated array.
     * Fields which are not fillable or don't exist in the given data array, will be ignored.
     *
     * Use the optional $prefix parameter to differ the required field names in the data array.
     *
     * @param array       $data
     * @param string|null $prefix (optional) The prefix for the array-key name to get the attribute values.
     *
     * @return static
     */
    public function fillFromArray(array $data, ?string $prefix = null): self
    {
        if (empty($data)) {
            return $this;
        }

        if (method_exists($this, 'getFillable') && method_exists($this, 'fill')) {
            $fillableData = [];
            foreach ($this->getFillable() as $fillableAttribute) {
                $key = $prefix . $fillableAttribute;
                if (array_key_exists($key, $data)) {
                    $fillableData[$fillableAttribute] = $data[$key];
                }
            }

            if (!empty($fillableData)) {
                $this->fill($fillableData);
            }
        }

        return $this;
    }
}
