<?php

declare(strict_types=1);

namespace DMX\Support\Database\Eloquent\Models\Concerns;

use Illuminate\Http\Request;

trait CanBeFilledByRequest
{
    use CanBeFilledByArray;

    /**
     * @param Request     $request
     * @param string|null $prefix  (optional) The prefix for the array-key name to get the attribute values.
     *
     * @return static
     */
    public function fillByRequest(Request $request, ?string $prefix = null): self
    {
        if ($request->isJson()) {
            return $this->fillFromArray($request->json()->all(), $prefix);
        }

        return $this->fillFromArray($request->all(), $prefix);
    }
}
