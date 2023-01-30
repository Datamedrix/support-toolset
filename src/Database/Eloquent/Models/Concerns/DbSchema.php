<?php

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
    protected string $schemaTableConcatDelimiter = ConnectionManager::SCHEMA_TABLE_CONCAT_DELIMITER;

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
        return ConnectionManager::mutateTableName(
            parent::getTable(),
            $this->getSchemaName(),
            $this->getDatabaseDriverName(),
            $this->schemaTableConcatDelimiter
        );
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
