<?php

namespace Tests\Unit;

use Tests\Unit\Mock\MockDto;
use PHPUnit\Framework\TestCase;

class DtoTest extends TestCase
{
	private $_mockData;

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

		$dtos = MockDto::mapArray( $data );

		$dto = $dtos[0];

		$this->assertEquals( $this->_mockData['name'], $dto->getName() );
		$this->assertEquals( $this->_mockData['count'], $dto->getCount() );
		$this->assertEquals( $this->_mockData['is_true'], $dto->getIsTrue() );
	}

	public function testMapArraySerialized()
	{
		$data = [
			$this->_mockData
		];

		$dtos = MockDto::mapArray( $data, true );

		$dtoSerialized = $dtos[0];

		$this->assertEquals( $this->_mockData['name'], $dtoSerialized->name );
		$this->assertEquals( $this->_mockData['count'], $dtoSerialized->count );
		$this->assertEquals( $this->_mockData['is_true'], $dtoSerialized->isTrue );
	}
}
