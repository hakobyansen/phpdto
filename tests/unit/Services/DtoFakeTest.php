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

		putenv('PHP_DTO_PATTERNS_DIR='.__DIR__ . '/../../files/');

		$this->_patternPath = 'dto_pattern.json';
	}

	/**
	 * @throws \Exception
	 */
	public function testFakeSingle()
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
	public function testFakeArray()
	{
		$length = 5;
		$data = DtoFaker::fakeArrayFromPattern( $this->_patternPath, $length );

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
