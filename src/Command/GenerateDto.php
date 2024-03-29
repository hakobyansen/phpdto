<?php

namespace PhpDto\Command;

use PhpDto\Services\ClassValueObject;
use PhpDto\Services\DtoBuilder;

class GenerateDto extends Command
{
	/**
	 * @param resource $handle
	 * @param array $dtoConfigs
	 */
	public function execute( $handle, array $dtoConfigs ): void
	{
		$classVo = $this->mapClassVO( $dtoConfigs );

		$this->_writer->write( $handle, $classVo );
	}

	/**
	 * @param array $dtoConfigs
	 * @return ClassValueObject
	 */
	public function mapClassVO( array $dtoConfigs ): ClassValueObject
	{
		$ValueObject = new ClassValueObject();
		$DtoBuilder = new DtoBuilder();

		$ValueObject->setNamespace( $DtoBuilder->getNamespace( $dtoConfigs ) )
			->setModules( $DtoBuilder->getModules( $dtoConfigs ) )
			->setClassName( $DtoBuilder->getClassName( $dtoConfigs ) )
			->setTraits( $DtoBuilder->getTraits() )
			->setProps( $DtoBuilder->getProps( $dtoConfigs ) )
			->setMethods( $DtoBuilder->getMethods( $dtoConfigs ) )
			->setConstructorParam( $DtoBuilder->getConstructorParam( $dtoConfigs ) )
			->setConstructorProps( $DtoBuilder->getConstructorProps( $dtoConfigs ) );

		return $ValueObject;
	}
}
