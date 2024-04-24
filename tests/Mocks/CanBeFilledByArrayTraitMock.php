<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Mocks;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use DMX\Support\Database\Eloquent\Models\Concerns\CanBeFilledByArray;

class CanBeFilledByArrayTraitMock extends EloquentModel
{
    use CanBeFilledByArray;

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
