<?php

declare(strict_types=1);

namespace DMX\Support\Database\Schema;

use Illuminate\Support\Fluent;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\Blueprint as BaseBlueprint;

class Blueprint extends BaseBlueprint
{
    public const int STRING_IDENTIFIER_LENGTH = 64;

    /**
     * Specify a raw column to the table.
     * Could be used to add a column with database specific data types if the database engine supports it like PostgreSQL.
     *
     * @param string $columnType
     * @param string $columnName
     *
     * @return ColumnDefinition
     */
    public function rawColumn(string $columnType, string $columnName): ColumnDefinition
    {
        return $this->addColumn('raw', $columnName, ['raw_type' => $columnType]);
    }

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
     *      'inclImportedBy' => false,
     *      'foreignIdLength' => 256,
     *      'referenceRestrictions' => [
     *          'onUpdate' => 'no action',
     *          'onDelete' => 'no action'
     *      ],
     *  ]
     * ```
     *
     * @param string $referencedTo Full qualified name of the user table (incl. schema if needed).
     * @param array  $options      Available options: nullableCreatedBy, nullableUpdatedBy, inclSoftDeletes, inclImportedBy, foreignIdLength and referenceRestrictions
     *
     * @return void
     */
    public function blamable(string $referencedTo = 'users', array $options = []): void
    {
        // Normalize the options.
        $options = array_merge(
            [
                'nullableCreatedBy' => true,
                'nullableUpdatedBy' => true,
                'inclSoftDeletes' => false,
                'inclImportedBy' => false,
                'foreignIdLength' => 256,
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
        if ($options['inclImportedBy'] === true) {
            $this->foreignId('imported_by')->nullable();
            $this->string('imported_foreign_id', (int) ($options['foreignIdLength'] ?? 1024))->nullable();
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

            if ($options['inclImportedBy'] === true) {
                $this
                    ->foreign('imported_by')
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
     *   [
     *       'nullableCreatedBy' => true,
     *       'nullableUpdatedBy' => true,
     *       'inclSoftDeletes' => false,
     *       'inclImportedBy' => false,
     *       'foreignIdLength' => 256,
     *       'referenceRestrictions' => [
     *           'onUpdate' => 'no action',
     *           'onDelete' => 'no action'
     *       ],
     *   ]
     *  ```
     *
     * @param string $referencedTo Full qualified name of the user table (incl. schema if needed).
     * @param int    $precision
     * @param array  $options      Available options: nullableCreatedBy, nullableUpdatedBy, inclSoftDeletes, inclImportedBy, foreignIdLength and referenceRestrictions
     *
     * @return void
     */
    public function blamableInclTimestamps(string $referencedTo = 'users', int $precision = 0, array $options = []): void
    {
        // Normalize the options.
        $options = array_merge(
            [
                'inclSoftDeletes' => false,
                'inclImportedBy' => false,
            ],
            $options
        );

        $this->timestamps($precision);
        if ($options['inclSoftDeletes'] === true) {
            $this->softDeletes('deleted_at', $precision);
        }
        if ($options['inclImportedBy'] === true) {
            $this->timestamp('imported_at', $precision)->nullable();
        }
        $this->blamable($referencedTo, $options);
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
     * Create a new UUID column on the table.
     *
     * @param string      $column
     * @param bool        $unique
     * @param string|null $indexName
     * @param string|null $uniqueIndexName
     *
     * @return Fluent
     */
    public function uuid($column = 'uuid', bool $unique = true, ?string $indexName = null, ?string $uniqueIndexName = null): Fluent
    {
        if (!empty($indexName)) {
            $columnDefinition = parent::uuid((string) $column)
                ->index($indexName)
            ;
        } else {
            $columnDefinition = parent::uuid((string) $column)
                ->index()
            ;
        }
        $columnDefinition->charset('ascii');

        if ($unique === true) {
            if (!empty($uniqueIndexName)) {
                $columnDefinition->unique($uniqueIndexName);
            } else {
                $columnDefinition->unique();
            }
        }

        return $columnDefinition;
    }
}
