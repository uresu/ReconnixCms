<?php

namespace Reconnix\MainBundle\Entity\Menu;

use Doctrine\ORM\EntityRepository;

class MenuItemRepository extends EntityRepository{
	public function getMenuItems(){
		return $this->getEntityManager()
			->createQuery(
				'SELECT m
				FROM ReconnixMainBundle:Menu\MenuItem m
				WHERE m.category = :category
				ORDER BY m.weight DESC, m.name ASC'
			)->setParameter('category', 'front')
			->getResult();
	}

	public function getAdminMenuItems(){
		return $this->getEntityManager()
			->createQuery(
				'SELECT m
				FROM ReconnixMainBundle:Menu\MenuItem m
				WHERE m.category != :category'
			)->setParameter('category', 'front')
			->getResult();	
	}
}