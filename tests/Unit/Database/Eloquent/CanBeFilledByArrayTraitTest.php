<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Unit\Database\Eloquent;

use PHPUnit\Framework\TestCase;
use DMX\Support\Tests\Mocks\CanBeFilledByArrayTraitMock;

class CanBeFilledByArrayTraitTest extends TestCase
{
    /**
     * Test.
     */
    public function testMethodFillByArray(): void
    {
        $testObj = new CanBeFilledByArrayTraitMock();
        $testObj->setDateFormat('Y-m-d H:i:s');

        // use fillFromArray method with empty data - nothing should be set
        $testObj->fillFromArray([]);
        $this->assertNull($testObj->getAttribute('id'));
        $this->assertNull($testObj->getAttribute('name'));
        $this->assertNull($testObj->getAttribute('email'));
        $this->assertNull($testObj->getAttribute('created_at'));
        $this->assertNull($testObj->getAttribute('updated_at'));

        // test with data
        $data = [
            'id' => rand(100, 999),
            'name' => 'Name' . rand(100, 999),
            'email' => 'name' . rand(100, 999) . '@example.com',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'not_fillable' => 'awesome datamedrix',
        ];
        $testObj->fillFromArray($data);

        $this->assertEquals($data['id'], $testObj->getAttribute('id'));
        $this->assertEquals($data['name'], $testObj->getAttribute('name'));
        $this->assertEquals($data['email'], $testObj->getAttribute('email'));
        $this->assertEquals($data['created_at'], $testObj->getAttribute('created_at'));
        $this->assertEquals($data['updated_at'], $testObj->getAttribute('updated_at'));
        $this->assertNull($testObj->getAttribute('not_fillable'));
    }

    /**
     * Test.
     */
    public function testMethodFillByArrayWithPrefix(): void
    {
        $testObj = new CanBeFilledByArrayTraitMock();
        $testObj->setDateFormat('Y-m-d H:i:s');
        $data = [
            'test__id' => rand(100, 999),
            'test__name' => 'Name' . rand(100, 999),
            'test__email' => 'name' . rand(100, 999) . '@example.com',
            'test__created_at' => date('Y-m-d H:i:s'),
            'test__updated_at' => date('Y-m-d H:i:s'),
            'test__not_fillable' => 'awesome datamedrix',
        ];

        $testObj->fillFromArray($data, 'test__');

        $this->assertEquals($data['test__id'], $testObj->getAttribute('id'));
        $this->assertEquals($data['test__name'], $testObj->getAttribute('name'));
        $this->assertEquals($data['test__email'], $testObj->getAttribute('email'));
        $this->assertEquals($data['test__created_at'], $testObj->getAttribute('created_at'));
        $this->assertEquals($data['test__updated_at'], $testObj->getAttribute('updated_at'));
        $this->assertNull($testObj->getAttribute('not_fillable'));
    }
}
