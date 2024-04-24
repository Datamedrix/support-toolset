<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Unit\Database\Migrations;

use Closure;
use RuntimeException;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\DatabaseManager;
use DMX\Support\Tests\Mocks\MigrationMock;
use DMX\Support\Database\ConnectionManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\Attributes\DataProvider;

class MigrationTest extends TestCase
{
    /**
     * @var DatabaseManager|MockObject
     */
    private MockObject $dbmMock;

    /**
     * @var Connection|MockObject
     */
    private MockObject $connectionMock;

    /**
     * @var Builder|MockObject
     */
    private MockObject $schemaMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dbmMock = $this->getMockBuilder(DatabaseManager::class)->disableOriginalConstructor()->getMock();
        $this->connectionMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $this->schemaMock = $this->getMockBuilder(Builder::class)->disableOriginalConstructor()->getMock();

        $this->dbmMock
            ->expects($this->any())
            ->method('connection')
            ->with(null)
            ->willReturn($this->connectionMock)
        ;

        $this->connectionMock
            ->expects($this->any())
            ->method('getSchemaBuilder')
            ->willReturn($this->schemaMock)
        ;

        $this->schemaMock
            ->expects($this->any())
            ->method('blueprintResolver')
            ->with($this->isInstanceOf(Closure::class))
        ;
        $this->schemaMock
            ->expects($this->any())
            ->method('getConnection')
            ->willReturn($this->connectionMock)
        ;
    }

    /**
     * Test.
     */
    public function testConstructorThrowsException()
    {
        $this->expectException(RuntimeException::class);

        new MigrationMock();
    }

    /**
     * Test.
     */
    public function testMethodGetDriverName()
    {
        $randomDriverName = 'T' . rand(10, 99) . '_est';
        $this->connectionMock
            ->expects($this->once())
            ->method('getDriverName')
            ->willReturn($randomDriverName)
        ;

        $migration = new MigrationMock($this->dbmMock);
        $this->assertEquals($randomDriverName, $migration->callGetDriverName());
    }

    /**
     * Test.
     */
    public function testUsingMethods()
    {
        $randomDriverName = '';
        $this->connectionMock
            ->expects($this->any())
            ->method('getDriverName')
            ->willReturnReference($randomDriverName)
        ;

        $migration = new MigrationMock($this->dbmMock);

        $randomDriverName = 'T' . rand(10, 99) . '_est';
        $this->assertTrue($migration->callUsingDriver($randomDriverName));
        $this->assertFalse($migration->callUsingDriver($randomDriverName . 'Foo' . rand(100, 999)));
        $this->assertFalse($migration->callUsingMSSQL());
        $this->assertFalse($migration->callUsingMySQL());
        $this->assertFalse($migration->callUsingPostgreSQL());
        $this->assertFalse($migration->callUsingSqlLite());

        $randomDriverName = ConnectionManager::DRIVER_MSSQL;
        $this->assertTrue($migration->callUsingDriver($randomDriverName));
        $this->assertFalse($migration->callUsingDriver($randomDriverName . 'Foo' . rand(100, 999)));
        $this->assertTrue($migration->callUsingMSSQL());
        $this->assertFalse($migration->callUsingMySQL());
        $this->assertFalse($migration->callUsingPostgreSQL());
        $this->assertFalse($migration->callUsingSqlLite());

        $randomDriverName = ConnectionManager::DRIVER_POSTGRESQL;
        $this->assertTrue($migration->callUsingDriver($randomDriverName));
        $this->assertFalse($migration->callUsingDriver($randomDriverName . 'Foo' . rand(100, 999)));
        $this->assertFalse($migration->callUsingMSSQL());
        $this->assertFalse($migration->callUsingMySQL());
        $this->assertTrue($migration->callUsingPostgreSQL());
        $this->assertFalse($migration->callUsingSqlLite());

        $randomDriverName = ConnectionManager::DRIVER_MYSQL;
        $this->assertTrue($migration->callUsingDriver($randomDriverName));
        $this->assertFalse($migration->callUsingDriver($randomDriverName . 'Foo' . rand(100, 999)));
        $this->assertFalse($migration->callUsingMSSQL());
        $this->assertTrue($migration->callUsingMySQL());
        $this->assertFalse($migration->callUsingPostgreSQL());
        $this->assertFalse($migration->callUsingSqlLite());

        $randomDriverName = ConnectionManager::DRIVER_SQLITE;
        $this->assertTrue($migration->callUsingDriver($randomDriverName));
        $this->assertFalse($migration->callUsingDriver($randomDriverName . 'Foo' . rand(100, 999)));
        $this->assertFalse($migration->callUsingMSSQL());
        $this->assertFalse($migration->callUsingMySQL());
        $this->assertFalse($migration->callUsingPostgreSQL());
        $this->assertTrue($migration->callUsingSqlLite());
    }

    /**
     * Test.
     */
    public function testCurrentDriverSupportsSchemas()
    {
        $randomDriverName = '';
        $this->connectionMock
            ->expects($this->any())
            ->method('getDriverName')
            ->willReturnReference($randomDriverName)
        ;

        $migration = new MigrationMock($this->dbmMock);

        $randomDriverName = 'Foo' . rand(1000, 9999);
        $this->assertFalse($migration->callCurrentDriverSupportsSchemas());
        $randomDriverName = ConnectionManager::DRIVER_POSTGRESQL;
        $this->assertTrue($migration->callCurrentDriverSupportsSchemas());
        $randomDriverName = ConnectionManager::DRIVER_MSSQL;
        $this->assertTrue($migration->callCurrentDriverSupportsSchemas());
        $randomDriverName = ConnectionManager::DRIVER_MYSQL;
        $this->assertFalse($migration->callCurrentDriverSupportsSchemas());
        $randomDriverName = ConnectionManager::DRIVER_SQLITE;
        $this->assertFalse($migration->callCurrentDriverSupportsSchemas());
    }

    /**
     * @return array[]
     */
    public static function tableNameProvider(): array
    {
        return [
            // driver | expected | table | schema
            [ConnectionManager::DRIVER_MYSQL, 'my_table', 'my_table', null],
            [ConnectionManager::DRIVER_MYSQL, 'my_schema__my_table', 'my_table', 'my_schema'],
            [ConnectionManager::DRIVER_MYSQL, 'my_schema__my_table', 'my_schema__my_table', 'my_schema'],
            [ConnectionManager::DRIVER_MYSQL, 'my_schema__my_table', 'my_schema__my_table', null],
            [ConnectionManager::DRIVER_MYSQL, 'my_schema__my__long_table', 'my__long_table', 'my_schema'],
            [ConnectionManager::DRIVER_SQLITE, 'my_table', 'my_table', null],
            [ConnectionManager::DRIVER_SQLITE, 'my_schema__my_table', 'my_table', 'my_schema'],
            [ConnectionManager::DRIVER_SQLITE, 'my_schema__my_table', 'my_schema__my_table', 'my_schema'],
            [ConnectionManager::DRIVER_SQLITE, 'my_schema__my_table', 'my_schema__my_table', null],
            [ConnectionManager::DRIVER_SQLITE, 'my_schema__my__long_table', 'my__long_table', 'my_schema'],
            [ConnectionManager::DRIVER_POSTGRESQL, 'my_table', 'my_table', null],
            [ConnectionManager::DRIVER_POSTGRESQL, 'my_schema.my_table', 'my_table', 'my_schema'],
            [ConnectionManager::DRIVER_POSTGRESQL, 'my_schema.my_table', 'my_schema.my_table', 'my_schema'],
            [ConnectionManager::DRIVER_POSTGRESQL, 'my_schema.my_table', 'my_schema.my_table', null],
            [ConnectionManager::DRIVER_POSTGRESQL, 'my_schema.my__long_table', 'my__long_table', 'my_schema'],
            [ConnectionManager::DRIVER_MSSQL, 'my_table', 'my_table', null],
            [ConnectionManager::DRIVER_MSSQL, 'my_schema.my_table', 'my_table', 'my_schema'],
            [ConnectionManager::DRIVER_MSSQL, 'my_schema.my_table', 'my_schema.my_table', 'my_schema'],
            [ConnectionManager::DRIVER_MSSQL, 'my_schema.my_table', 'my_schema.my_table', null],
            [ConnectionManager::DRIVER_MSSQL, 'my_schema.my__long_table', 'my__long_table', 'my_schema'],
        ];
    }

    /**
     * Test.
     *
     * @param string      $driverName
     * @param string      $expected
     * @param string      $tableName
     * @param string|null $schemaName
     */
    #[DataProvider('tableNameProvider')]
    public function testMethodMutateTableName(string $driverName, string $expected, string $tableName, ?string $schemaName = null)
    {
        $this->connectionMock
            ->expects($this->any())
            ->method('getDriverName')
            ->willReturnReference($driverName)
        ;

        $migration = new MigrationMock($this->dbmMock);
        $this->assertEquals($expected, $migration->callMutateTableName($tableName, $schemaName));
    }

    /**
     * @return array[]
     */
    public static function createSchemaProvider(): array
    {
        return [
            // driver | expected | schema
            [ConnectionManager::DRIVER_MYSQL, '', 'my_schema'],
            [ConnectionManager::DRIVER_MYSQL, '', 'my_schema__my_table'],
            [ConnectionManager::DRIVER_SQLITE, '', 'my_schema'],
            [ConnectionManager::DRIVER_SQLITE, '', 'my_schema__my_table'],
            [ConnectionManager::DRIVER_POSTGRESQL, 'CREATE SCHEMA IF NOT EXISTS my_schema;', 'my_schema'],
            [ConnectionManager::DRIVER_POSTGRESQL, 'CREATE SCHEMA IF NOT EXISTS my_schema;', '  my_schema '],
            [ConnectionManager::DRIVER_MSSQL, "IF NOT EXISTS (SELECT 1 FROM sys.schemas WHERE name = 'my_schema') BEGIN EXEC( 'CREATE SCHEMA my_schema'); END", 'my_schema'],
            [ConnectionManager::DRIVER_MSSQL, "IF NOT EXISTS (SELECT 1 FROM sys.schemas WHERE name = 'my_schema') BEGIN EXEC( 'CREATE SCHEMA my_schema'); END", 'my_schema'],
        ];
    }

    /**
     * Test.
     *
     * @param string $driverName
     * @param string $expected
     * @param string $schemaName
     */
    #[DataProvider('createSchemaProvider')]
    public function testMethodCreateSchema(string $driverName, string $expected, string $schemaName)
    {
        $this->connectionMock
            ->expects($this->any())
            ->method('getDriverName')
            ->willReturnReference($driverName)
        ;

        $sql = (new MigrationMock($this->dbmMock))->callCreateCreateSchemaSql($schemaName);
        if (empty($expected)) {
            $this->assertNull($sql);
        } else {
            $this->assertEquals($expected, $sql);
        }
    }

    /**
     * @return array[]
     */
    public static function dropSchemaProvider(): array
    {
        return [
            // driver | expected | schema
            [ConnectionManager::DRIVER_MYSQL, '', 'my_schema'],
            [ConnectionManager::DRIVER_MYSQL, '', 'my_schema__my_table'],
            [ConnectionManager::DRIVER_SQLITE, '', 'my_schema'],
            [ConnectionManager::DRIVER_SQLITE, '', 'my_schema__my_table'],
            [ConnectionManager::DRIVER_POSTGRESQL, 'DROP SCHEMA IF EXISTS my_schema;', 'my_schema'],
            [ConnectionManager::DRIVER_POSTGRESQL, 'DROP SCHEMA IF EXISTS my_schema;', '  my_schema '],
            [ConnectionManager::DRIVER_MSSQL, 'DROP SCHEMA IF EXISTS my_schema;', 'my_schema'],
            [ConnectionManager::DRIVER_MSSQL, 'DROP SCHEMA IF EXISTS my_schema;', '  my_schema '],
        ];
    }

    /**
     * Test.
     *
     * @param string $driverName
     * @param string $expected
     * @param string $schemaName
     */
    #[DataProvider('dropSchemaProvider')]
    public function testMethodDropSchema(string $driverName, string $expected, string $schemaName)
    {
        $this->connectionMock
            ->expects($this->any())
            ->method('getDriverName')
            ->willReturnReference($driverName)
        ;

        $sql = (new MigrationMock($this->dbmMock))->callCreateDropSchemaSql($schemaName);
        if (empty($expected)) {
            $this->assertNull($sql);
        } else {
            $this->assertEquals($expected, $sql);
        }
    }

    /**
     * Test.
     */
    public function testMethodDbm()
    {
        $migration = new MigrationMock($this->dbmMock);
        $this->assertEquals($this->dbmMock, $migration->callDbm());
    }

    /**
     * Test.
     */
    public function testMethodSchema()
    {
        $migration = new MigrationMock($this->dbmMock);
        $this->assertEquals($this->schemaMock, $migration->callSchema());
    }
}
