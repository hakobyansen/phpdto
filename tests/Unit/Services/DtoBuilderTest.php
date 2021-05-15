<?php

namespace Tests\Unit\Services;

use PhpDto\Services\DtoBuilder;
use PHPUnit\Framework\TestCase;

class DtoBuilderTest extends TestCase
{
	/**
	 * @var DtoBuilder $_builder;
	 */
	private DtoBuilder $_builder;

	/**
	 * @var array $_configs
	 */
	private array $_configs;

	protected function setUp(): void
	{
		parent::setUp();

		$this->_builder = new DtoBuilder();

		$this->_configs = [
			'class' => 'item',
			'props' => [
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
			[ '\PhpDto\DtoSerialize' ],
			$this->_builder->getTraits()
		);
	}

	public function testGetProps()
	{
		$expected = [
			'private int $_id;',
			'private ?int $_count;',
			'private string $_name;',
			'private ?string $_description;',
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

	public function testConvertPropToSnakeCase()
	{
		$scProp = 'a_snake_case_prop';
		$ccProp = $this->_builder->convertPropToSnakeCase($scProp);
		$this->assertEquals('aSnakeCaseProp', $ccProp);

		$scProp = '_a_snake_case_prop';
		$ccProp = $this->_builder->convertPropToSnakeCase($scProp);
		$this->assertEquals('_aSnakeCaseProp', $ccProp);

		$scProp = '_somethingElse';
		$ccProp = $this->_builder->convertPropToSnakeCase($scProp);
		$this->assertEquals('_somethingElse', $ccProp);

		$scProp = 'short';
		$ccProp = $this->_builder->convertPropToSnakeCase($scProp);
		$this->assertEquals('short', $ccProp);

		$scProp = 'aNormalProp';
		$ccProp = $this->_builder->convertPropToSnakeCase($scProp);
		$this->assertEquals('aNormalProp', $ccProp);
	}
}
