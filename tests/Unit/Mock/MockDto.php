<?php

namespace Tests\Unit\Mock;

use PhpDto\Dto;
use PhpDto\ToArray;

class MockDto extends Dto
{
	use ToArray;

	private ?string $_name;

	private int $_count;

	private bool $_isTrue;

	private ?MockSubDto $_subDTO;

	public function __construct( array $data )
	{
		$this->_name   = $data['name'];
		$this->_count  = $data['count'];
		$this->_isTrue = $data['is_true'];
		$this->_subDTO = $data['sub_dto'] ?? null;
	}

	/**
	 * @return string|null
	 */
	public function getName(): ?string
	{
		return $this->_name;
	}

	/**
	 * @return int
	 */
	public function getCount(): int
	{
		return $this->_count;
	}

	/**
	 * @return bool
	 */
	public function getIsTrue(): bool
	{
		return $this->_isTrue;
	}

	/**
	 * @return MockSubDto|null
	 */
	public function getSubDTO(): ?MockSubDto
	{
		return $this->_subDTO;
	}
}
