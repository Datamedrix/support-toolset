<?php

declare(strict_types=1);

namespace DMX\Support\Tests\Unit\Database\Eloquent;

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use DMX\Support\Tests\Mocks\HasSnakeCaseAttributesTraitMock;

class HasSnakeCaseAttributesTraitTest extends TestCase
{
    /**
     * Test.
     */
    public function testMethodGetAttribute(): void
    {
        $testObj = new HasSnakeCaseAttributesTraitMock();
        $testObj->setDateFormat('Y-m-d H:i:s');
        $data = [
            'id' => rand(100, 999),
            'first_name' => 'FName' . rand(100, 999),
            'last_name' => 'LName' . rand(100, 999),
            'email' => 'name' . rand(100, 999) . '@example.com',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $testObj->fill($data);

        $this->assertEquals($data['id'], $testObj->getAttribute('id'));
        $this->assertEquals($data['email'], $testObj->getAttribute('email'));

        $this->assertEquals($data['first_name'], $testObj->getAttribute('first_name'));
        $this->assertEquals($data['first_name'], $testObj->getAttribute('firstName'));
        $this->assertEquals($testObj->getAttribute('first_name'), $testObj->getAttribute('firstName'));

        $this->assertEquals($data['last_name'], $testObj->getAttribute('last_name'));
        $this->assertEquals($data['last_name'], $testObj->getAttribute('lastName'));
        $this->assertEquals($testObj->getAttribute('last_name'), $testObj->getAttribute('lastName'));

        $this->assertEquals($data['created_at'], $testObj->getAttribute('created_at'));
        $this->assertEquals($data['created_at'], $testObj->getAttribute('createdAt'));
        $this->assertEquals($testObj->getAttribute('created_at'), $testObj->getAttribute('createdAt'));

        $this->assertEquals($data['updated_at'], $testObj->getAttribute('updated_at'));
        $this->assertEquals($data['updated_at'], $testObj->getAttribute('updatedAt'));
        $this->assertEquals($testObj->getAttribute('updated_at'), $testObj->getAttribute('updatedAt'));
    }

    /**
     * Test.
     */
    public function testMethodSetAttribute(): void
    {
        $testObj = new HasSnakeCaseAttributesTraitMock();
        $testObj->setDateFormat('Y-m-d H:i:s');
        $data = [
            'id' => rand(100, 999),
            'first_name' => 'FName' . rand(100, 999),
            'last_name' => 'LName' . rand(100, 999),
            'email' => 'name' . rand(100, 999) . '@example.com',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        foreach ($data as $key => $value) {
            $snakeCaseKey = Str::snake($key);
            $testObj->setAttribute($snakeCaseKey, $value);
            $this->assertEquals($value, $testObj->getAttribute($key));
            $this->assertEquals($value, $testObj->getAttribute($snakeCaseKey));
            $this->assertEquals($testObj->getAttribute($key), $testObj->getAttribute($snakeCaseKey));
        }
    }
}
