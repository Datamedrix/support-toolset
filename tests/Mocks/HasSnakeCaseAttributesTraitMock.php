<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Mocks;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use DMX\Support\Database\Eloquent\Models\Concerns\HasSnakeCaseAttributes;

class HasSnakeCaseAttributesTraitMock extends EloquentModel
{
    use HasSnakeCaseAttributes;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'created_at',
        'updated_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
