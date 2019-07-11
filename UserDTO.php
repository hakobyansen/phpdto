<?php

namespace App\DTO;

class UserDTO extends DTO
{
    private $_name;
    private $_age;

    public function __construct( array $user )
    {
        $this->_name = $user['name'];
        $this->_age  = $user['age'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getAge(): string
    {
        return $this->_age;
    }
}
