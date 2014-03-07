<?php

namespace Reconnix\DepInjBundle\Classes;

class Address{

	public $houseNumber;

	public function __construct($houseNumber){
		$this->houseNumber = $houseNumber;
	}
}