<?php

namespace Tests\Unit\Services;

use PhpDto\Services\DtoFaker;
use PHPUnit\Framework\TestCase;

class DtoFakeTest extends TestCase
{
	/**
	 * @var string $_patternPath
	 */
	private $_patternPath;

	public function setUp(): void
	{
		parent::setUp();

		$this->_patternPath = __DIR__ . '/../../files/dto_pattern.json';
	}

	/**
	 * @throws \Exception
	 */
	public function testFakeSingle()
	{
		$data = DtoFaker::fakeSingle( $this->_patternPath );

		$this->assertTrue( is_int($data['id']) );
		$this->assertTrue( is_int($data['count']) || is_null($data['count']) );
		$this->assertTrue( is_string($data['name']) );
		$this->assertTrue( is_string($data['description']) || is_null($data['description']) );
	}

	/**
	 * @throws \Exception
	 */
	public function testFakeArray()
	{
		$length = 5;
		$data = DtoFaker::fakeArray( $this->_patternPath, $length );

		$this->assertEquals( $length, count($data) );
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
