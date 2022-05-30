<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2019 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

namespace DMX\Support\Database\Schema;

use Illuminate\Support\Fluent;
use Illuminate\Database\Schema\Blueprint as BaseBlueprint;

class Blueprint extends BaseBlueprint
{
    public const STRING_IDENTIFIER_LENGTH = 64;

    /**
     * {@inheritdoc}
     */
    public function timestamps($precision = 0): void
    {
        $this->timestamp('created_at', $precision)->useCurrent();
        $this->timestamp('updated_at', $precision)->nullable()->useCurrentOnUpdate();
    }

    /**
     * Add nullable creation and update references to the designated users table to the table.
     *
     * @param string $referencedTo
     * @param bool   $inclSoftDeletes
     * @param array  $referenceRestrictions
     *
     * @return void
     */
    public function userAudit(string $referencedTo = 'users', bool $inclSoftDeletes = false, array $referenceRestrictions = ['onUpdate' => 'no action', 'onDelete' => 'no action']): void
    {
        $this->foreignId('created_by');
        $this->foreignId('updated_by')->nullable();
        if ($inclSoftDeletes) {
            $this->foreignId('deleted_by')->nullable();
        }

        $referencedTo = trim($referencedTo);
        if (!empty($referencedTo)) {
            $this
                ->foreign('created_by')
                ->references('id')
                ->on($referencedTo)
                ->onUpdate($referenceRestrictions['onUpdate'] ?? 'no action')
                ->onDelete($referenceRestrictions['onDelete'] ?? 'no action')
            ;

            $this
                ->foreign('updated_by')
                ->references('id')
                ->on($referencedTo)
                ->onUpdate($referenceRestrictions['onUpdate'] ?? 'no action')
                ->onDelete($referenceRestrictions['onDelete'] ?? 'no action')
            ;

            if ($inclSoftDeletes) {
                $this
                    ->foreign('deleted_by')
                    ->references('id')
                    ->on($referencedTo)
                    ->onUpdate($referenceRestrictions['onUpdate'] ?? 'no action')
                    ->onDelete($referenceRestrictions['onDelete'] ?? 'no action')
                ;
            }
        }
    }

    /**
     * Add nullable creation and update references to the designated users table and timestamps to the table.
     *
     * @param string $referencedTo
     * @param int    $precision
     * @param bool   $inclSoftDeletes
     * @param array  $referenceRestrictions
     *
     * @return void
     */
    public function userAuditInclTimestamps(string $referencedTo = 'users', int $precision = 0, bool $inclSoftDeletes = false, array $referenceRestrictions = ['onUpdate' => 'no action', 'onDelete' => 'no action']): void
    {
        $this->timestamps($precision);
        if ($inclSoftDeletes) {
            $this->softDeletes($precision);
        }
        $this->userAudit($referencedTo, $inclSoftDeletes, $referenceRestrictions);
    }

    /**
     * Add an identifier string (= VARCHAR(64) with charset 'ascii') to the table.
     *
     * @param string $column Name of the designated column
     *
     * @return Fluent
     */
    public function stringIdentifier(string $column): Fluent
    {
        return $this->string($column, self::STRING_IDENTIFIER_LENGTH)->charset('ascii');
    }

    /**
     * {@inheritdoc}
     */
    public function uuid($column = 'uuid'): Fluent
    {
        return parent::uuid((string) $column)->unique()->index()->charset('ascii');
    }
}
