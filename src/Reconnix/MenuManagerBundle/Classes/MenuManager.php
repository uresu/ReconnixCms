<?php

namespace Reconnix\MenuManagerBundle\Classes;

use Doctrine\Bundle\DoctrineBundle\Registry;

class MenuManager{

	private $doctrine;

	public function __construct(Registry $doctrine){
		$this->doctrine = $doctrine;
	}

	public function getMenuItems($repository){
		return $this->doctrine
        ->getRepository($repository)
        ->createQueryBuilder('m')
        ->where('m.category = :category')
        ->setParameter('category', 'front')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();
	}

	public function getAdminMenuItems($repository){
		return $this->doctrine
        ->getRepository($repository)
        ->createQueryBuilder('m')
        ->where('m.category != :category')
        ->setParameter('category', 'front')
        ->getQuery()
        ->getResult();		
	}
}