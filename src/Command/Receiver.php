<?php

namespace PhpDto\Command;

use PhpDto\Dto;
use PhpDto\Services\ClassValueObject;
use PhpDto\Services\Binder;

class Receiver
{
	/**
	 * @param $handle
	 * @param ClassValueObject $class
	 */
	public function write($handle, ClassValueObject $class): void
	{
		$bind = new Binder();

		$bind->head( $class->getNamespace() )->eol();

		if( !empty( $class->getModules() ) )
		{
			$bind->eol()->modules( $class->getModules() )->eol();
		}

		$bind->class( $class->getClassName(), 'Dto');

		if( !empty( $class->getTraits() ) )
		{
			$bind->traits( $class->getTraits() )->eol();
		}

		if( !empty( $class->getProps() ) )
		{
			$bind->props( $class->getProps() )->eol();
		}

		if( !empty( $class->getConstructorProps() ) )
		{
			$bind->constructor( $class->getConstructorParam(), $class->getConstructorProps() )->eol()->eol();
		}

		if( !empty( $class->getMethods() ) )
		{
			$bind->methods( $class->getMethods() )->eol();
		}

		fwrite( $handle, $bind->getOutput() );

		$this->printMessage( $class->getNamespace().'\\'.$class->getClassName() );
	}

	/**
	 * @param string $namespace
	 */
	public function printMessage( string $namespace ): void
	{
		echo "$namespace generated.\n";
	}
}


