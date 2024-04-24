<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Unit\Database\Eloquent;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use DMX\Support\Tests\Mocks\CanBeFilledByRequestTraitMock;

class CanBeFilledByRequestTraitTest extends TestCase
{
    /**
     * Test.
     */
    public function testMethodFillByRequest(): void
    {
        $testObj = new CanBeFilledByRequestTraitMock();
        $testObj->setDateFormat('Y-m-d H:i:s');
        $data = [
            'id' => rand(100, 999),
            'name' => 'Name' . rand(100, 999),
            'email' => 'name' . rand(100, 999) . '@example.com',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'not_fillable' => 'awesome datamedrix',
        ];
        $request = Request::create('test.local', Request::METHOD_POST, $data);

        $testObj->fillByRequest($request);

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
    public function testMethodFillByRequestWithPrefix(): void
    {
        $testObj = new CanBeFilledByRequestTraitMock();
        $testObj->setDateFormat('Y-m-d H:i:s');
        $data = [
            'test__id' => rand(100, 999),
            'test__name' => 'Name' . rand(100, 999),
            'test__email' => 'name' . rand(100, 999) . '@example.com',
            'test__created_at' => date('Y-m-d H:i:s'),
            'test__updated_at' => date('Y-m-d H:i:s'),
            'test__not_fillable' => 'awesome datamedrix',
        ];
        $request = Request::create('test.local', Request::METHOD_POST, $data);

        $testObj->fillByRequest($request, 'test__');

        $this->assertEquals($data['test__id'], $testObj->getAttribute('id'));
        $this->assertEquals($data['test__name'], $testObj->getAttribute('name'));
        $this->assertEquals($data['test__email'], $testObj->getAttribute('email'));
        $this->assertEquals($data['test__created_at'], $testObj->getAttribute('created_at'));
        $this->assertEquals($data['test__updated_at'], $testObj->getAttribute('updated_at'));
        $this->assertNull($testObj->getAttribute('not_fillable'));
    }

    /**
     * Test.
     */
    public function testMethodFillByRequestWithJsonData(): void
    {
        $testObj = new CanBeFilledByRequestTraitMock();
        $testObj->setDateFormat('Y-m-d H:i:s');
        $data = [
            'id' => rand(100, 999),
            'name' => 'Name' . rand(100, 999),
            'email' => 'name' . rand(100, 999) . '@example.com',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'not_fillable' => 'awesome datamedrix',
        ];
        $request = Request::create(
            'test.local',
            Request::METHOD_POST,
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode($data)
        );

        $testObj->fillByRequest($request);

        $this->assertEquals($data['id'], $testObj->getAttribute('id'));
        $this->assertEquals($data['name'], $testObj->getAttribute('name'));
        $this->assertEquals($data['email'], $testObj->getAttribute('email'));
        $this->assertEquals($data['created_at'], $testObj->getAttribute('created_at'));
        $this->assertEquals($data['updated_at'], $testObj->getAttribute('updated_at'));
        $this->assertNull($testObj->getAttribute('not_fillable'));
    }
}
