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
     * Complete options with default values:
     * ```php
     *  [
     *      'nullableCreatedBy' => true,
     *      'nullableUpdatedBy' => true,
     *      'inclSoftDeletes' => false,
     *      'referenceRestrictions' => [
     *          'onUpdate' => 'no action',
     *          'onDelete' => 'no action'
     *      ],
     *  ]
     * ```
     *
     * @param string $referencedTo Full qualified name of the user table (incl. schema if needed).
     * @param array  $options      Available options: nullableCreatedBy, nullableUpdatedBy, inclSoftDeletes and referenceRestrictions
     *
     * @return void
     */
    public function userAudit(string $referencedTo = 'users', array $options = []): void
    {
        // Normalize the options.
        $options = array_merge(
            [
                'nullableCreatedBy' => true,
                'nullableUpdatedBy' => true,
                'inclSoftDeletes' => false,
                'referenceRestrictions' => [
                    'onUpdate' => 'no action',
                    'onDelete' => 'no action',
                ],
            ],
            $options
        );

        $this->foreignId('created_by')->nullable((bool) $options['nullableCreatedBy']);
        $this->foreignId('updated_by')->nullable((bool) $options['nullableUpdatedBy']);
        if ($options['inclSoftDeletes'] === true) {
            $this->foreignId('deleted_by')->nullable();
        }

        $referencedTo = trim($referencedTo);
        if (!empty($referencedTo)) {
            $this
                ->foreign('created_by')
                ->references('id')
                ->on($referencedTo)
                ->onUpdate($options['referenceRestrictions']['onUpdate'] ?? 'no action')
                ->onDelete($options['referenceRestrictions']['onDelete'] ?? 'no action')
            ;

            $this
                ->foreign('updated_by')
                ->references('id')
                ->on($referencedTo)
                ->onUpdate($options['referenceRestrictions']['onUpdate'] ?? 'no action')
                ->onDelete($options['referenceRestrictions']['onDelete'] ?? 'no action')
            ;

            if ($options['inclSoftDeletes'] === true) {
                $this
                    ->foreign('deleted_by')
                    ->references('id')
                    ->on($referencedTo)
                    ->onUpdate($options['referenceRestrictions']['onUpdate'] ?? 'no action')
                    ->onDelete($options['referenceRestrictions']['onDelete'] ?? 'no action')
                ;
            }
        }
    }

    /**
     * Add nullable creation and update references to the designated users table and timestamps to the table.
     *
     * Complete options with default values:
     * ```php
     *  [
     *      'nullableCreatedBy' => true,
     *      'nullableUpdatedBy' => true,
     *      'inclSoftDeletes' => false,
     *      'referenceRestrictions' => [
     *          'onUpdate' => 'no action',
     *          'onDelete' => 'no action'
     *      ],
     *  ]
     * ```
     *
     * @param string $referencedTo Full qualified name of the user table (incl. schema if needed).
     * @param int    $precision
     * @param array  $options      Available options: nullableCreatedBy, nullableUpdatedBy, inclSoftDeletes and referenceRestrictions
     *
     * @return void
     */
    public function userAuditInclTimestamps(string $referencedTo = 'users', int $precision = 0, array $options = []): void
    {
        // Normalize the options.
        $options = array_merge(
            [
                'inclSoftDeletes' => false,
                'referenceRestrictions' => [
                    'onUpdate' => 'no action',
                    'onDelete' => 'no action',
                ],
            ],
            $options
        );

        $this->timestamps($precision);
        if ($options['inclSoftDeletes'] === true) {
            $this->softDeletes('deleted_at', $precision);
        }
        $this->userAudit($referencedTo, $options);
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
