<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Mocks;

use DMX\Support\Database\Migrations\Migration;

class MigrationMock extends Migration
{
    /**
     * {@inheritDoc}
     */
    public function up(): void
    {
    }

    /**
     * {@inheritDoc}
     */
    public function down(): void
    {
    }

    /**
     * Mock method: calls protected function getDriverName().
     *
     * @return string
     */
    public function callGetDriverName(): string
    {
        return $this->getDriverName();
    }

    /**
     * Mock method: calls protected function usingDriver().
     *
     * @param string $driverName
     *
     * @return bool
     */
    public function callUsingDriver(string $driverName): bool
    {
        return $this->usingDriver($driverName);
    }

    /**
     * Mock method: calls protected function usingMSSQL().
     *
     * @return bool
     */
    public function callUsingMSSQL(): bool
    {
        return $this->usingMSSQL();
    }

    /**
     * Mock method: calls protected function usingPostgreSQL().
     *
     * @return bool
     */
    public function callUsingPostgreSQL(): bool
    {
        return $this->usingPostgreSQL();
    }

    /**
     * Mock method: calls protected function usingMySQL().
     *
     * @return bool
     */
    public function callUsingMySQL(): bool
    {
        return $this->usingMySQL();
    }

    /**
     * Mock method: calls protected function usingSqlLite().
     *
     * @return bool
     */
    public function callUsingSqlLite(): bool
    {
        return $this->usingSqlLite();
    }

    /**
     * Mock method: calls protected function currentDriverSupportsSchemas().
     *
     * @return bool
     */
    public function callCurrentDriverSupportsSchemas(): bool
    {
        return $this->currentDriverSupportsSchemas();
    }

    /**
     * Mock method: calls protected function mutateTableName().
     *
     * @param string      $tableName
     * @param string|null $schemaName
     *
     * @return string
     */
    public function callMutateTableName(string $tableName, ?string $schemaName = null): string
    {
        return $this->mutateTableName($tableName, $schemaName);
    }

    /**
     * Mock method: calls protected function createCreateSchemaSql().
     *
     * @param string $schemaName
     *
     * @return string|null
     */
    public function callCreateCreateSchemaSql(string $schemaName): ?string
    {
        return $this->createCreateSchemaSql($schemaName);
    }

    /**
     * Mock method: calls protected function createDropSchemaSql().
     *
     * @param string $schemaName
     *
     * @return string|null
     */
    public function callCreateDropSchemaSql(string $schemaName): ?string
    {
        return $this->createDropSchemaSql($schemaName);
    }
}
