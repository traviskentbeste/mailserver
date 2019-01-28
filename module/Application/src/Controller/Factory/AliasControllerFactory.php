<?php

namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Application\Controller\AliasController;
use Application\Service\AliasManager;

class AliasControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $aliasManager = $container->get(AliasManager::class);

        return new AliasController($entityManager, $aliasManager);

    }

}