<?php

namespace Tests\Unit\Services;

use PhpDto\Services\DtoFaker;
use PHPUnit\Framework\TestCase;

class DtoFakerTest extends TestCase
{
	/**
	 * @var DtoFaker $_faker
	 */
	private $_faker;
	/**
	 * @var string $_patternPath
	 */
	private $_patternPath;

	public function setUp(): void
	{
		parent::setUp();

		$this->_faker = new DtoFaker();

		putenv('PHP_DTO_PATTERNS_DIR='.__DIR__ . '/../../files/');

		$this->_patternPath = 'dto_pattern.json';
	}

	/**
	 * @throws \Exception
	 */
	public function testFakeSingleFromPattern()
	{
		$data = $this->_faker->fakeSingleFromPattern( $this->_patternPath );

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
		$data = $this->_faker->fakeArrayFromPattern( $this->_patternPath, $length );

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
