<?php

namespace Tests\Unit\Services;

use PhpDto\Dto;
use PhpDto\DtoSerialize;
use PhpDto\Services\DtoBuilder;
use PHPUnit\Framework\TestCase;

class DtoBuilderTest extends TestCase
{
	/**
	 * @var DtoBuilder $_builder;
	 */
	private $_builder;

	/**
	 * @var $_configs
	 */
	private $_configs;

	protected function setUp(): void
	{
		parent::setUp();

		$this->_builder = new DtoBuilder();

		$this->_configs = [
			'class' => 'item',
			'rules' => [
				'id' => 'int',
				'count' => 'nullable|int',
				'name' => 'string',
				'description' => 'nullable|string'
			]
		];
	}

	public function testGetNamespace()
	{
		putenv('PHP_DTO_NAMESPACE=App\DTO');

		$this->assertEquals(
			'App\DTO',
			$this->_builder->getNamespace( $this->_configs )
		);
	}

	public function testGetNamespaceWithPostfix()
	{
		putenv('PHP_DTO_NAMESPACE=App\DTO');

		$postfix = '\Item';

		$this->_configs['namespace_postfix'] = $postfix;

		$this->assertEquals(
			'App\DTO'.$postfix,
			$this->_builder->getNamespace( $this->_configs )
		);
	}

	public function testGetClassName()
	{
		putenv('PHP_DTO_CLASS_POSTFIX=DTO');

		$this->assertEquals(
			'ItemDTO',
			$this->_builder->getClassName( $this->_configs )
		);
	}

	public function testGetModules()
	{
		$this->assertEquals(
			[],
			$this->_builder->getModules()
		);
	}

	public function testGetTraits()
	{
		$this->assertEquals(
			[ 'PhpDto\DtoSerialize' ],
			$this->_builder->getTraits()
		);
	}

	public function testGetProps()
	{
		$expected = [
			'private $_id;',
			'private $_count;',
			'private $_name;',
			'private $_description;',
		];

		$this->assertEquals(
			$expected,
			$this->_builder->getProps( $this->_configs, 'private' )
		);
	}

	public function testGetConstructorParam()
	{
		$this->assertEquals(
			$this->_configs['class'],
			$this->_builder->getConstructorParam( $this->_configs )
		);
	}

	public function testGetConstructorProps()
	{
		$expected = [
			'id', 'count', 'name', 'description'
		];

		$this->assertEquals(
			$expected,
			$this->_builder->getConstructorProps( $this->_configs )
		);
	}

	public function testGetMethods()
	{
		$expected = [
			[
				'visibility' => 'public',
				'declaration' => 'function getId(): int',
				'body' => 'return $this->_id;'
			],
			[
				'visibility' => 'public',
				'declaration' => 'function getCount(): ?int',
				'body' => 'return $this->_count;'
			],
			[
				'visibility' => 'public',
				'declaration' => 'function getName(): string',
				'body' => 'return $this->_name;'
			],
			[
				'visibility' => 'public',
				'declaration' => 'function getDescription(): ?string',
				'body' => 'return $this->_description;'
			],
		];

		$this->assertEquals(
			$expected,
			$this->_builder->getMethods( $this->_configs, 'public' )
		);
	}
}
