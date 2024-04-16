<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Unit\Database\Schema;

use Illuminate\Support\Fluent;
use DMX\Support\Tests\ATestCase;
use DMX\Support\Database\Schema\Blueprint;
use PHPUnit\Framework\MockObject\MockObject;

class BlueprintTest extends ATestCase
{
    /**
     * @var Blueprint|MockObject
     */
    private MockObject $blueprint;

    /**
     * @var Fluent|MockObject
     */
    private MockObject $fluentMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->fluentMock = $this->getMockBuilder(Fluent::class)->disableOriginalConstructor()->getMock();
        $this->blueprint = $this->getMockBuilder(Blueprint::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['timestamp', 'string', '__call', 'addColumn'])
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
            ->with(
                ...self::withConsecutive(
                    ['unique'],
                    ['index'],
                    ['charset']
                )
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
            ->with(
                ...self::withConsecutive(
                    ['created_at', $dummyPrecision],
                    ['updated_at', $dummyPrecision]
                )
            )
            ->willReturnOnConsecutiveCalls($fluentMock1, $fluentMock2)
        ;

        $fluentMock1
            ->expects($this->once())
            ->method('__call')
            ->with('useCurrent')
            ->willReturnSelf()
        ;

        $fluentMock2
            ->expects($this->exactly(2))
            ->method('__call')
            ->with(
                ...self::withConsecutive(
                    ['nullable'],
                    ['useCurrentOnUpdate'],
                )
            )
            ->willReturnSelf()
        ;

        $this->blueprint->timestamps($dummyPrecision);
    }
}
