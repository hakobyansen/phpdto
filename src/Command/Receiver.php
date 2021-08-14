<?php

namespace PhpDto\Command;

use PhpDto\Dto;
use PhpDto\Services\ClassValueObject;
use PhpDto\Services\Sticker;

class Receiver
{
	/**
	 * @param $handle
	 * @param ClassValueObject $class
	 */
	public function write($handle, ClassValueObject $class): void
	{
		$stick = new Sticker();

		$stick->head( $class->getNamespace() )->eol();

		if( !empty( $class->getModules() ) )
		{
			$stick->eol()->modules( $class->getModules() )->eol();
		}

		$stick->class( $class->getClassName(), '\\'.Dto::class );

		if( !empty( $class->getTraits() ) )
		{
			$stick->traits( $class->getTraits() )->eol();
		}

		if( !empty( $class->getProps() ) )
		{
			$stick->props( $class->getProps() )->eol();
		}

		if( !empty( $class->getConstructorProps() ) )
		{
			$stick->constructor( $class->getConstructorParam(), $class->getConstructorProps() )->eol()->eol();
		}

		if( !empty( $class->getMethods() ) )
		{
			$stick->methods( $class->getMethods() )->eol();
		}

		fwrite( $handle, $stick->getOutput() );

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


