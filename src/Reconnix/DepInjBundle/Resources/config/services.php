<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

$container->setParameter('address.class', 'Reconnix\DepInjBundle\Classes\Address');
$container->setParameter('address.number', 'marcus');
$container->setDefinition('address', new Definition(
	'%address.class%',
	array('%address.number%')
));

$container->setParameter('user.class', 'Reconnix\DepInjBundle\Classes\User');
$container->setDefinition('user', new Definition(
	'%user.class%',
	array(new Reference('doctrine'))
))->addMethodCall('setAddress', array(
	new Reference('address')
));