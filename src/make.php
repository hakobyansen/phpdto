<?php

require 'vendor\autoload.php';

use PhpDto\Cli\Handler;
use PhpDto\Services\Maker;
use PhpDto\Services\DTOConfig;

try
{
	$handler = new Handler();
	$handler->handleArgs( $_SERVER['argv'] );

	$dtoConfig = new DTOConfig();
	$dtoConfig->setConfigs( $handler );

	$maker = new Maker( $dtoConfig->getConfigs(), $handler );

	$maker->makeDTO();

	if( $handler->isGenerateUnitTest() )
	{
		$maker->makeUnitTest();
	}
}
catch ( \Exception $exception )
{
	echo $exception->getMessage();
}
