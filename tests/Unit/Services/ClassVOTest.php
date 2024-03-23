<?php

namespace Tests\Unit\Services;

use PhpDto\Services\ClassValueObject;
use PHPUnit\Framework\TestCase;

class ClassVOTest extends TestCase
{
	private ClassValueObject $_valueObject;

	protected function setUp(): void
	{
		parent::setUp();

		$this->_valueObject = new ClassValueObject();
	}

	public function testSetNamespace()
	{
		$namespace = 'A\B';

		$this->_valueObject->setNameSpace( $namespace );

		$this->assertEquals( $namespace, $this->_valueObject->getNamespace() );
	}

	public function testSetModules()
	{
		$modules = [ 'SomeModule', 'AnotherModules' ];

		$this->_valueObject->setModules( $modules );

		$this->assertEquals( $modules, $this->_valueObject->getModules() );
	}

	public function testSetModulesNull()
	{
		$modules = null;

		$this->_valueObject->setModules( $modules );

		$this->assertEquals( $modules, $this->_valueObject->getModules() );
	}

	public function testSetClassName()
	{
		$className = 'C';

		$this->_valueObject->setClassName( $className );

		$this->assertEquals( $className, $this->_valueObject->getClassName() );
	}

	public function testSetTraits()
	{
		$traits = [ 'T' ];

		$this->_valueObject->setTraits( $traits );

		$this->assertEquals( $traits, $this->_valueObject->getTraits() );
	}

	public function testSetTraitsNull()
	{
		$traits = null;

		$this->_valueObject->setTraits( $traits );

		$this->assertEquals( $traits, $this->_valueObject->getTraits() );
	}

	public function testSetProps()
	{
		$props = [ 'P', 'F' ];

		$this->_valueObject->setProps( $props );

		$this->assertEquals( $props, $this->_valueObject->getProps() );
	}

	public function testSetPropsNull()
	{
		$props = null;

		$this->_valueObject->setProps( $props );

		$this->assertEquals( $props, $this->_valueObject->getProps() );
	}

	public function testSetMethods()
	{
		$methods = [ 'M' ];

		$this->_valueObject->setMethods( $methods );

		$this->assertEquals( $methods, $this->_valueObject->getMethods() );
	}

	public function testSetMethodsNull()
	{
		$methods = null;

		$this->_valueObject->setMethods( $methods );

		$this->assertEquals( $methods, $this->_valueObject->getMethods() );
	}

	public function testSetConstructorParam()
	{
		$param = 'param';

		$this->_valueObject->setConstructorParam( $param );

		$this->assertEquals( $param, $this->_valueObject->getConstructorParam() );
	}

	public function testSetConstructorProps()
	{
		$constructorProps = [ 'ConstProp' ];

		$this->_valueObject->setConstructorProps( $constructorProps );

		$this->assertEquals( $constructorProps, $this->_valueObject->getConstructorProps() );
	}

	public function testSetConstructorPropsNull()
	{
		$constructorProps = null;

		$this->_valueObject->setConstructorProps( $constructorProps );

		$this->assertEquals( $constructorProps, $this->_valueObject->getConstructorProps() );
	}
}
