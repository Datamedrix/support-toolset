<?php

declare(strict_types=1);

namespace DMX\Support\Database\Eloquent\Models\Concerns;

use DMX\Support\Database\ConnectionManager;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Trait DbSchema.
 *
 * @mixin EloquentModel
 */
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
     * @param string $schema
     *
     * @return $this|EloquentModel
     */
    public function setSchemaName(string $schema): self
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSchemaName(): ?string
    {
        return !empty($this->schema) ? trim((string) $this->schema) : null;
    }

    /**
     * @param string $delimiter
     *
     * @return $this|EloquentModel
     */
    public function setSchemaTableConcatDelimiter(string $delimiter): self
    {
        $this->schemaTableConcatDelimiter = trim($delimiter);

        return $this;
    }

    public function getSchemaTableConcatDelimiter(): string
    {
        return $this->schemaTableConcatDelimiter;
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
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
        return $this->getConnection()?->getDriverName() ?? '';
    }

    /**
     * @param string $driverName
     *
     * @return bool
     *
     * @codeCoverageIgnore
     */
    protected function usingDriver(string $driverName): bool
    {
        return strtolower($this->getDatabaseDriverName()) === strtolower($driverName);
    }

    /**
     * @return bool
     *
     * @codeCoverageIgnore
     */
    protected function usingMySQL(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_MYSQL);
    }

    /**
     * @return bool
     *
     * @codeCoverageIgnore
     */
    protected function usingPostgreSQL(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_POSTGRESQL);
    }

    /**
     * @return bool
     *
     * @codeCoverageIgnore
     */
    protected function usingMSSQL(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_MSSQL);
    }

    /**
     * @return bool
     *
     * @codeCoverageIgnore
     */
    protected function usingSqlLite(): bool
    {
        return $this->usingDriver(ConnectionManager::DRIVER_SQLITE);
    }

    /**
     * @return bool
     *
     * @codeCoverageIgnore
     */
    protected function currentDriverSupportsSchemas(): bool
    {
        return $this->usingPostgreSQL() || $this->usingMSSQL();
    }
}
