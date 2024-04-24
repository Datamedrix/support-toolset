<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Mocks;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use DMX\Support\Database\Eloquent\Models\Concerns\CanBeFilledByRequest;

class CanBeFilledByRequestTraitMock extends EloquentModel
{
    use CanBeFilledByRequest;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',
    ];
}
