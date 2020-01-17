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

trait DbSchema
{
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
        return !empty($this->schema) ? (string) $this->schema : null;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        $tableName = parent::getTable();
        $schema = $this->getSchemaName();
        if (!empty($schema) && $this->usingPostgreSQL()) {
            return $schema . '.' . $tableName;
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
        return $this->usingDriver('mysql');
    }

    /**
     * @return bool
     */
    protected function usingPostgreSQL(): bool
    {
        return $this->usingDriver('pgsql');
    }

    /**
     * @return bool
     */
    protected function usingMSSQL(): bool
    {
        return $this->usingDriver('sqlsrv');
    }

    /**
     * @return bool
     */
    protected function usingSqlLite(): bool
    {
        return $this->usingDriver('sqlite');
    }
}
