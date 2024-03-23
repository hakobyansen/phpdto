<?php

namespace Tests\Unit\Mock;

use PhpDto\Dto;
use PhpDto\ToArray;

class MockSubDto extends Dto
{
	use ToArray;

	private ?string $_subName;

	private int $_subCount;

	private ?self $_subSubDto;

	public function __construct( array $data )
	{
		$this->_subName  = $data['sub_name'];
		$this->_subCount = $data['sub_count'];

		if(isset($data['sub_sub_dto']))
		{
			$this->_subSubDto = new self($data['sub_sub_dto']);
		}
	}

	/**
	 * @return string|null
	 */
	public function getSubName(): ?string
	{
		return $this->_subName;
	}

	/**
	 * @return int
	 */
	public function getSubCount(): int
	{
		return $this->_subCount;
	}

	/**
	 * @return self|null
	 */
	public function getSubSubDto(): ?self
	{
		return $this->_subSubDto;
	}
}
