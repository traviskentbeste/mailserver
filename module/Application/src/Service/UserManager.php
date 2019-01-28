<?php

namespace Application\Service;

/**
 * This service is responsible for adding/editing entity.
 */
class UserManager
{

    /**
     * Doctrine entity manager.
     * @var DoctrineORMntityManager
     */
    private $entityManager;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager)
    {

        $this->entityManager = $entityManager;

    }

    /**
     * This method adds a new entity.
     */
    public function add(&$obj)
    {

        // Add the entity to the entity manager.
        $this->entityManager->persist($obj);

        // Apply changes to database.
        $this->entityManager->flush();

    }

    /**
     * This method updates data of an existing user.
     */
    public function update()
    {

        // Apply changes to database.
        $this->entityManager->flush();

    }

}

