<?php

namespace Reconnix\DepInjBundle\Classes;

use Doctrine\Bundle\DoctrineBundle\Registry;

class User{

	private $doctrine;
	private $address;

	public function __construct(Registry $doctrine){
		$this->doctrine = $doctrine;
	}

	public function setAddress($address){
		$this->address = $address;
	}

	public function getAddress(){
		return $this->address;
	}

	public function getBlocks(){
		return $this->doctrine->getRepository('ReconnixMainBundle:Content\Block')->findAll();
	}
}