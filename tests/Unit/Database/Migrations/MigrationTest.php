<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2018 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

namespace DMX\Support\Tests\Unit\Database\Migrations;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\DatabaseManager;
use PHPUnit\Framework\MockObject\MockObject;
use DMX\Support\Database\Migrations\Migration;

class MigrationTest extends TestCase
{
    /**
     * @var DatabaseManager|MockObject
     */
    private $dbmMock;

    /**
     * @var Connection|MockObject
     */
    private $connectionMock;

    /**
     * @var Builder|MockObject
     */
    private $schemaMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dbmMock = $this->getMockBuilder(DatabaseManager::class)->disableOriginalConstructor()->getMock();
        $this->connectionMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $this->schemaMock = $this->getMockBuilder(Builder::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Test.
     */
    public function testConstructor()
    {
        $this->dbmMock
            ->expects($this->once())
            ->method('connection')
            ->with(null)
            ->willReturn($this->connectionMock)
        ;

        $this->connectionMock
            ->expects($this->once())
            ->method('getSchemaBuilder')
            ->willReturn($this->schemaMock)
        ;

        $this->schemaMock
            ->expects($this->once())
            ->method('blueprintResolver')
            ->with($this->isInstanceOf(\Closure::class))
        ;

        new Migration($this->dbmMock);
    }

    /**
     * Test.
     */
    public function testConstructorThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Migration();
    }
}
