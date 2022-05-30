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

namespace DMX\Support\Database\Eloquent\Models\Concerns;

use DMX\Support\Database\ConnectionManager;

trait DbSchema
{
    /**
     * Delimiter used to concat the database schema- and the table-name if the database engine does not support schemas.
     *
     * @var string
     */
    protected string $schemaTableConcatDelimiter = '__';

    /**
     * The database schema name associated with the model.
     *
     * @var string|null
     */
    protected ?string $schema = null;

    /**
     * @return string|null
     */
    public function getSchemaName(): ?string
    {
        return !empty($this->schema) ? trim((string) $this->schema) : null;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        $tableName = parent::getTable();
        $schema = $this->getSchemaName();
        if (!empty($schema)) {
            if ($this->currentDriverSupportsSchemas()) {
                if (str_contains($tableName, '.')) {
                    // if a schema is already added to the table name, do not add them twice!
                    return $tableName;
                }

                return $schema . '.' . $tableName;
            }

            if (str_contains($tableName, $schema . $this->schemaTableConcatDelimiter)) {
                // if a schema name is already added to the table name, do not add them twice!
                return $tableName;
            }

            return $schema . $this->schemaTableConcatDelimiter . $tableName;
        }

        return $tableName;
    }

    /**
     * @return string
     */
    protected function getDatabaseDriverName(): string
    {
        return $this->getConnection()->getDriverName();
    }

    /**
     * @param string $driverName
     *
     * @return bool
     */
    protected function usingDriver(string $driverName): bool
    {
        return strtolower($this->getDatabaseDriverName()) === strtolower($driverName);
    }

    /**
     * @return bool
     */
    protected function usingMySQL(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_MYSQL);
    }

    /**
     * @return bool
     */
    protected function usingPostgreSQL(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_POSTGRESQL);
    }

    /**
     * @return bool
     */
    protected function usingMSSQL(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_MSSQL);
    }

    /**
     * @return bool
     */
    protected function usingSqlLite(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_SQLITE);
    }

    /**
     * @return bool
     */
    protected function currentDriverSupportsSchemas(): bool
    {
        return $this->usingPostgreSQL() || $this->usingMSSQL();
    }
}
