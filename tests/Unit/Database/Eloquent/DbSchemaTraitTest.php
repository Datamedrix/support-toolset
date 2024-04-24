<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Unit\Database\Eloquent;

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Connection;
use DMX\Support\Database\ConnectionManager;
use DMX\Support\Tests\Mocks\DbSchemaTraitMock;
use Illuminate\Database\ConnectionResolverInterface;

class DbSchemaTraitTest extends TestCase
{
    /**
     * Test.
     */
    public function testMethodGetSchemaName(): void
    {
        $schema = 'Dummy' . rand(100, 999) . '_' . date('Ymd_His') . '_' . rand(100000, 999999);
        $testObj = new DbSchemaTraitMock();
        $testObj->setSchemaName($schema);

        $this->assertEquals($schema, $testObj->getSchemaName());
    }

    /**
     * Test.
     */
    public function testMethodGetSchemaTableConcatDelimiter(): void
    {
        $delimiter = '__' . rand(100, 999) . '_' . date('Ymd_His') . '_' . rand(100000, 999999);
        $testObj = new DbSchemaTraitMock();
        $testObj->setSchemaTableConcatDelimiter($delimiter);

        $this->assertEquals($delimiter, $testObj->getSchemaTableConcatDelimiter());
    }

    /**
     * Test.
     */
    public function testMethodGetTable(): void
    {
        $connectionResolverMock = $this->createMock(ConnectionResolverInterface::class);
        $connectionMock = $this->createMock(Connection::class);

        $connectionResolverMock
            ->expects($this->atLeastOnce())
            ->method('connection')
            ->willReturn($connectionMock)
        ;

        $connectionMock
            ->expects($this->atLeastOnce())
            ->method('getDriverName')
            ->willReturn(ConnectionManager::DRIVER_MYSQL)
        ;

        DbSchemaTraitMock::setConnectionResolver($connectionResolverMock);

        $delimiter = 'D' . rand(0, 9) . 'D';
        $table = 'tbl' . rand(100, 999) . '_' . date('Ymd_His') . '_' . rand(100000, 999999) . 's';
        $schema = 'test' . rand(100, 999);

        // Test call of parent model method
        $testObj = new DbSchemaTraitMock();
        $this->assertEquals(Str::snake(Str::pluralStudly(class_basename($testObj))), $testObj->getTable());

        // Test without schema
        $testObj = new DbSchemaTraitMock();
        $testObj
            ->setTable($table)
        ;
        $this->assertEquals($table, $testObj->getTable());

        // Test with schema
        $testObj = new DbSchemaTraitMock();
        $testObj
            ->setTable($table)
            ->setSchemaName($schema)
        ;
        $this->assertEquals($schema . ConnectionManager::SCHEMA_TABLE_CONCAT_DELIMITER . $table, $testObj->getTable());

        $testObj->setSchemaTableConcatDelimiter($delimiter);
        $this->assertEquals($schema . $delimiter . $table, $testObj->getTable());
    }
}
