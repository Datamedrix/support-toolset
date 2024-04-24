<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Unit\Database;

use PHPUnit\Framework\TestCase;
use DMX\Support\Database\ConnectionManager;

class ConnectionManagerTest extends TestCase
{
    /**
     * Test.
     */
    public function testMethodIsDriverSupportingSchemas(): void
    {
        $this->assertTrue(
            ConnectionManager::isDriverSupportingSchemas(ConnectionManager::DRIVER_MSSQL)
        );
        $this->assertTrue(
            ConnectionManager::isDriverSupportingSchemas(ConnectionManager::DRIVER_POSTGRESQL)
        );
        $this->assertFalse(
            ConnectionManager::isDriverSupportingSchemas(ConnectionManager::DRIVER_MYSQL)
        );
        $this->assertFalse(
            ConnectionManager::isDriverSupportingSchemas(ConnectionManager::DRIVER_SQLITE)
        );
        $this->assertFalse(
            ConnectionManager::isDriverSupportingSchemas('driver' . rand(100, 999))
        );
    }

    /**
     * Test.
     */
    public function testMethodMutateTableName(): void
    {
        $tableName = 'tbl' . rand(100, 999);
        $schemaName = 's' . rand(100, 999);
        $driverName = ConnectionManager::DRIVER_MSSQL;
        $delimiter = '__' . rand(100, 999);

        $this->assertEquals(
            $tableName,
            ConnectionManager::mutateTableName($tableName)
        );

        $this->assertEquals(
            $schemaName . ConnectionManager::SCHEMA_TABLE_CONCAT_DELIMITER . $tableName,
            ConnectionManager::mutateTableName($tableName, $schemaName)
        );

        $this->assertEquals(
            $schemaName . '.' . $tableName,
            ConnectionManager::mutateTableName($tableName, $schemaName, $driverName)
        );

        $this->assertEquals(
            $schemaName . '.' . $tableName,
            ConnectionManager::mutateTableName($tableName, $schemaName, $driverName, $delimiter)
        );

        $this->assertEquals(
            $schemaName . '.' . $tableName,
            ConnectionManager::mutateTableName($schemaName . '.' . $tableName, $schemaName, $driverName, $delimiter)
        );

        $this->assertEquals(
            $schemaName . $delimiter . $tableName,
            ConnectionManager::mutateTableName($tableName, $schemaName, ConnectionManager::DRIVER_MYSQL, $delimiter)
        );
    }
}
