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

namespace DMX\Support\Tests\Unit\Database\Schema;

use Illuminate\Support\Fluent;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Query\Expression;
use DMX\Support\Database\Schema\Blueprint;
use PHPUnit\Framework\MockObject\MockObject;

class BlueprintTest extends TestCase
{
    /**
     * @var Blueprint|MockObject
     */
    private $blueprint;

    /**
     * @var Fluent|MockObject
     */
    private $fluentMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->fluentMock = $this->getMockBuilder(Fluent::class)->disableOriginalConstructor()->getMock();
        $this->blueprint = $this->getMockBuilder(Blueprint::class)
            ->disableOriginalConstructor()
            ->setMethods(['timestamp', 'string', '__call', 'addColumn'])
            ->getMock()
        ;
    }

    /**
     * Test.
     */
    public function testMethodStringIdentifier()
    {
        $dummyColumnName = 'col_' . rand(100, 999);
        $this->blueprint
            ->expects($this->once())
            ->method('string')
            ->with($dummyColumnName, Blueprint::STRING_IDENTIFIER_LENGTH)
            ->willReturn($this->fluentMock)
        ;

        $this->fluentMock
            ->expects($this->once())
            ->method('__call')
            ->with('charset', ['ascii'])
            ->willReturnSelf()
        ;

        $this->assertEquals($this->fluentMock, $this->blueprint->stringIdentifier($dummyColumnName));
    }

    /**
     * Test.
     */
    public function testMethodUuid()
    {
        $dummyColumnName = 'col_' . rand(100, 999);
        $this->blueprint
            ->expects($this->once())
            ->method('addColumn')
            ->with('uuid', $dummyColumnName)
            ->willReturn($this->fluentMock)
        ;

        $this->fluentMock
            ->expects($this->exactly(3))
            ->method('__call')
            ->withConsecutive(
                ['unique'],
                ['index'],
                ['charset', ['ascii']]
            )
            ->willReturnSelf()
        ;

        $this->blueprint->uuid($dummyColumnName);
    }

    /**
     * Test.
     */
    public function testMethodTimestamps()
    {
        $dummyPrecision = rand(1, 10);

        $fluentMock1 = $this->getMockBuilder(Fluent::class)->disableOriginalConstructor()->getMock();
        $fluentMock2 = $this->getMockBuilder(Fluent::class)->disableOriginalConstructor()->getMock();

        $this->blueprint
            ->expects($this->exactly(2))
            ->method('timestamp')
            ->withConsecutive(
                ['created_at', $dummyPrecision],
                ['updated_at', $dummyPrecision]
            )
            ->willReturnOnConsecutiveCalls($fluentMock1, $fluentMock2)
        ;

        $fluentMock1
            ->expects($this->once())
            ->method('__call')
            ->with('default', [new Expression('NOW()')])
            ->willReturnSelf()
        ;

        $fluentMock2
            ->expects($this->once())
            ->method('__call')
            ->with('nullable', [])
            ->willReturnSelf()
        ;

        $this->blueprint->timestamps($dummyPrecision);
    }
}
