<?php

namespace PhpDto\Command;

use PhpDto\Dto;
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

		$stick->head( $classVO->getNamespace() )->doubleEol();

		if( !empty( $classVO->getModules() ) )
		{
			$stick->eol()->modules( $classVO->getModules() )->eol();
		}

		$stick->class( $classVO->getClassName(), '\\'.Dto::class );

		if( !empty( $classVO->getTraits() ) )
		{
			$stick->traits( $classVO->getTraits() )->eol();
		}

		if( !empty( $classVO->getProps() ) )
		{
			$stick->props( $classVO->getProps() )->eol();
		}

		if( !empty( $classVO->getConstructorProps() ) )
		{
			$stick->constructor( $classVO->getConstructorParam(), $classVO->getConstructorProps() )->doubleEol();
		}

		if( !empty( $classVO->getMethods() ) )
		{
			$stick->methods( $classVO->getMethods() )->eol();
		}

		fwrite( $handle, $stick->getOutput() );
	}
}


