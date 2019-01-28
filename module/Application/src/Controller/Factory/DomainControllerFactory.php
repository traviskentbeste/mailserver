<?php

namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Application\Controller\DomainController;
use Application\Service\DomainManager;

class DomainControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $domainManager = $container->get(DomainManager::class);

        return new DomainController($entityManager, $domainManager);

    }

}