<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2021 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author        Christian Graf <c.graf@datamedrix.com>
 */
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
