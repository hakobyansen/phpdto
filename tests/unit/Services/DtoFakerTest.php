<?php

namespace Tests\Unit\Services;

use PhpDto\Services\DtoFaker;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Mock\MockDto;

class DtoFakerTest extends TestCase
{
	/**
	 * @var string $_patternPath
	 */
	private $_patternPath;

	/**
	 * @var array $_mockData
	 */
	private $_mockData;

	public function setUp(): void
	{
		parent::setUp();

		$this->_patternPath = __DIR__ . '/../../files/dto_pattern.json';

		$this->_mockData = [
			'name' => 'Mock name',
			'count' => 4,
			'is_true' => true
		];
	}

	/**
	 * @throws \ReflectionException
	 */
	public function testFakeSingle()
	{
		$dto = MockDto::mapSingle( $this->_mockData );

		$data = DtoFaker::fakeSingle( $dto );

		$this->assertTrue( is_int($data['count']) || is_null($data['count']) );
		$this->assertTrue( is_string($data['name']) );
		$this->assertTrue( is_bool($data['is_true']) );
	}

	/**
	 * @throws \ReflectionException
	 */
	public function testFakeArray()
	{
		$dto = MockDto::mapSingle( $this->_mockData );

		$length = 5;
		$data = DtoFaker::fakeArray( $dto, $length );

		$this->assertEquals( $length, count($data) );

		// testing the default value of $length param of fakeArray method
		$data = DtoFaker::fakeArray( $dto );

		$this->assertEquals( 10, count($data) );

	}

	/**
	 * @throws \Exception
	 */
	public function testFakeSingleFromPattern()
	{
		$data = DtoFaker::fakeSingleFromPattern( $this->_patternPath );

		$this->assertTrue( is_int($data['id']) );
		$this->assertTrue( is_int($data['count']) || is_null($data['count']) );
		$this->assertTrue( is_string($data['name']) );
		$this->assertTrue( is_string($data['description']) || is_null($data['description']) );
	}

	/**
	 * @throws \Exception
	 */
	public function testFakeArrayFromPattern()
	{
		$length = 5;
		$data = DtoFaker::fakeArrayFromPattern( $this->_patternPath, $length );

		$this->assertEquals( $length, count($data) );

		// testing the default value of $length param of fakeArrayFromPattern method
		$data = DtoFaker::fakeArrayFromPattern( $this->_patternPath );

		$this->assertEquals( 10, count($data) );
	}

	/**
	 * @throws \Exception
	 */
	public function testRandomString()
	{
		$expectedLength = 10;
		$randomString = DtoFaker::randomString( $expectedLength );

		$this->assertEquals( $expectedLength, strlen($randomString) );
	}
}
