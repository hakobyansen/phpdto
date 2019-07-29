<?php

namespace PhpDto\Command;

use PhpDto\Services\ClassVO;
use PhpDto\Services\Sticker;

class Receiver
{
	/**
	 * @param $handle
	 * @param ClassVO $classVO
	 */
	public function write($handle, ClassVO $classVO): void
	{
		$stick = new Sticker();

		$stick->head( $classVO->getNamespace() )->eol();

		if( !empty( $classVO->getModules() ) )
		{
			$stick->modules( $classVO->getModules() )->doubleEol();
		}

		$stick->class( $classVO->getClassName() );

		if( !empty( $classVO->getTraits() ) )
		{
			$stick->traits( $classVO->getTraits() );
		}

		if( !empty( $classVO->getProps() ) )
		{
			$stick->props( $classVO->getProps() )->doubleEol();
		}

		if( !empty( $classVO->getConstructorProps() ) )
		{
			$stick->constructor($classVO->getConstructorParam(), $classVO->getConstructorProps() );
		}

		if( !empty( $classVO->getMethods() ) )
		{
			$stick->methods( $classVO->getMethods() );
		}

		fwrite( $handle, $stick->getOutput() );
	}
}


