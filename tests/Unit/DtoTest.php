<?php

namespace Tests\Unit;

use Tests\Unit\Mock\MockDto;
use PHPUnit\Framework\TestCase;

class DtoTest extends TestCase
{
	private array $_mockData;

	protected function setUp(): void
	{
		parent::setUp();

		$this->_mockData = [
			'name' => 'Mock name',
			'count' => 4,
			'is_true' => true
		];
	}

	public function testMapSingle()
	{
		$dto = MockDto::mapSingle( $this->_mockData );

		$this->assertEquals( $this->_mockData['name'], $dto->getName() );
		$this->assertEquals( $this->_mockData['count'], $dto->getCount() );
		$this->assertEquals( $this->_mockData['is_true'], $dto->getIsTrue() );

		$this->_mockData['name'] = null;

		$dto = MockDto::mapSingle( $this->_mockData );

		$this->assertNull( $dto->getName() );
	}

	public function testMapSingleSerialized()
	{
		$dtoSerialized = MockDto::mapSingle( $this->_mockData, true );

		$this->assertEquals( $this->_mockData['name'], $dtoSerialized->name );
		$this->assertEquals( $this->_mockData['count'], $dtoSerialized->count );
		$this->assertEquals( $this->_mockData['is_true'], $dtoSerialized->isTrue );
	}

	public function testMapArray()
	{
		$data = [
			$this->_mockData
		];

		$dtoAr = MockDto::mapArray( $data );

		$dto = $dtoAr[0];

		$this->assertEquals( $this->_mockData['name'], $dto->getName() );
		$this->assertEquals( $this->_mockData['count'], $dto->getCount() );
		$this->assertEquals( $this->_mockData['is_true'], $dto->getIsTrue() );
	}

	public function testMapArraySerialized()
	{
		$data = [
			$this->_mockData
		];

		$dtoAr = MockDto::mapArray( $data, true );

		$dtoSerialized = $dtoAr[0];

		$this->assertEquals( $this->_mockData['name'], $dtoSerialized->name );
		$this->assertEquals( $this->_mockData['count'], $dtoSerialized->count );
		$this->assertEquals( $this->_mockData['is_true'], $dtoSerialized->isTrue );
	}

	public function testToArray()
	{
		$dto = new MockDto($this->_mockData);

		$arr = $dto->toArray();

		$this->assertEquals( $this->_mockData['name'], $arr['name'] );
		$this->assertEquals( $this->_mockData['count'], $arr['count'] );
		$this->assertEquals( $this->_mockData['is_true'], $arr['count'] );

		$arr = $dto->toArray(toSnakeCase: false);

		$this->assertArrayHasKey('isTrue', $arr);

		$keyPrefix = 'id.';

		$arr = $dto->toArray(keyPrefix: $keyPrefix);

		$this->assertEquals( $this->_mockData['name'], $arr["{$keyPrefix}name"] );
		$this->assertEquals( $this->_mockData['count'], $arr["{$keyPrefix}count"] );
		$this->assertEquals( $this->_mockData['is_true'], $arr["{$keyPrefix}is_true"] );
	}
}
