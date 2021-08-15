<?php

namespace Tests\Unit\Services;

use PhpDto\Enum\Types;
use PhpDto\Services\DtoBuilder;
use PhpDto\Services\PropsHelper;
use PhpDto\Types\Prop;
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
			'modules' => [
				'Path\To\FirstCustomType',
				'Path\To\SecondCustomType',
			],
			'props' => [
				'id' => 'int',
				'count' => '?int',
				'name' => 'string',
				'description' => '?string',
				'first_custom_type' => 'FirstCustomType',
				'second_custom_type' => '?SecondCustomType',
				'third_custom_type' => 'Path\To\ThirdCustomType',
				'fourth_custom_type' => '?Path\To\FourthCustomType',
			],
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

	public function testGetModules()
	{
		$types = new Types();
		$expected = $this->_configs['modules'];

		foreach ($this->_configs['props'] as $prop)
		{
			$prop = str_replace('?', '', $prop);

			if( !$types->hasValue($prop) && !$this->_builder->isPropInModules($prop, $expected) )
			{
				$expected[] = $prop;
			}
		}

		$this->assertEquals(
			$expected,
			$this->_builder->getModules( $this->_configs )
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

	public function testGetTraits()
	{
		$this->assertEquals(
			[ 'DtoSerialize' ],
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
			'private FirstCustomType $_firstCustomType;',
			'private ?SecondCustomType $_secondCustomType;',
			'private ThirdCustomType $_thirdCustomType;',
			'private ?FourthCustomType $_fourthCustomType;',
		];

		$this->assertEquals(
			$expected,
			$this->_builder->getProps( $this->_configs )
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
		$props = $this->_builder->getConstructorProps( $this->_configs );

		$propNames = [
			'id',
			'count',
			'name',
			'description',
			'firstCustomType',
			'secondCustomType',
			'thirdCustomType',
			'fourthCustomType'
		];

		$this->assertEquals(
			expected: $propNames,
			actual: PropsHelper::getPropNames(props: $props)
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
			[
				'visibility' => 'public',
				'declaration' => 'function getFirstCustomType(): FirstCustomType',
				'body' => 'return $this->_firstCustomType;'
			],
			[
				'visibility' => 'public',
				'declaration' => 'function getSecondCustomType(): ?SecondCustomType',
				'body' => 'return $this->_secondCustomType;'
			],
			[
				'visibility' => 'public',
				'declaration' => 'function getThirdCustomType(): ThirdCustomType',
				'body' => 'return $this->_thirdCustomType;'
			],
			[
				'visibility' => 'public',
				'declaration' => 'function getFourthCustomType(): ?FourthCustomType',
				'body' => 'return $this->_fourthCustomType;'
			],
		];

		$this->assertEquals(
			$expected,
			$this->_builder->getMethods( $this->_configs )
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
