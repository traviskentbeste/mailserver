<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\ViewModel;

use Application\Entity\Alias;
use Application\Entity\User;
use Application\Form\AliasForm;

class AliasController extends AbstractActionController
{

    /**
     * Entity manager.cc
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $aliasManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $aliasManager)
    {

        $this->entityManager = $entityManager;
        $this->aliasManager = $aliasManager;

    }

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {

        $aliases = $this->entityManager->getRepository(Alias::class)->findAll();

        return new ViewModel([
            'aliases' => $aliases
        ]);

    }

    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function addAction()
    {

        $users = $this->entityManager->getRepository(User::class)->findAll();
        $form = new AliasForm('create', $users);
        $form->bind(new Alias());

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $post = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            // set the raw form data
            $formDataRaw = $post;

            if ((isset($formDataRaw['cancel'])) && ($formDataRaw['cancel'] == 'Cancel')) {
                return $this->redirect()->toRoute('alias', ['action' => 'index']);
            }

            // set data in to the form
            $form->setData($formDataRaw);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $alias = $form->getData();

                // wrap this all in a transaction
                $this->entityManager->getConnection()->beginTransaction();

                try {

                    // set the domain
                    $user = $this->entityManager->getRepository(User::class)->find($formDataRaw['user']);
                    $alias->setUser($user);

                    $this->aliasManager->add($alias);

                    $this->entityManager->getConnection()->commit();

                } catch (Exception $e) {

                    // rollback
                    $this->entityManager->getConnection()->rollBack();

                    throw $e;
                }

                // Redirect to "edit" page
                if (isset($formDataRaw['save_and_edit']) && ($formDataRaw['save_and_edit'] == 'Save And Edit')) {
                    return $this->redirect()->toRoute('alias', ['action' => 'edit', 'id' => $alias->getId()]);
                }

                // Redirect to "index" page
                return $this->redirect()->toRoute('alias', ['action' => 'index']);
            }
        }

        return new ViewModel([
            'form' => $form
        ]);

    }

    /**
     * @return void|\Zend\Http\Response|ViewModel
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function editAction()
    {

        $id = $this->params()->fromRoute('id', NULL);
        $alias = $this->entityManager->getRepository(Alias::class)->find($id);

        if ($alias === NULL) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $users = $this->entityManager->getRepository(User::class)->findAll();
        $form = new AliasForm('create', $users);
        $form->bind($alias);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $post = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            // set the raw form data
            $formDataRaw = $post;

            if ((isset($formDataRaw['cancel'])) && ($formDataRaw['cancel'] == 'Cancel')) {
                return $this->redirect()->toRoute('alias', ['action' => 'index']);
            }

            // set data in to the form
            $form->setData($formDataRaw);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $alias = $form->getData();

                // wrap this all in a transaction
                $this->entityManager->getConnection()->beginTransaction();

                try {

                    // set the domain
                    if ( isset($formDataRaw['user']) && ($formDataRaw['user'] != '') ) {
                        $user = $this->entityManager->getRepository(User::class)->find($formDataRaw['user']);
                        $alias->setUser($user);
                    }

                    $this->aliasManager->update($alias);

                    $this->entityManager->getConnection()->commit();

                } catch (Exception $e) {

                    // rollback
                    $this->entityManager->getConnection()->rollBack();

                    throw $e;
                }

                // Redirect to "edit" page
                if (isset($formDataRaw['save_and_edit']) && ($formDataRaw['save_and_edit'] == 'Save And Edit')) {
                    return $this->redirect()->toRoute('alias', ['action' => 'edit', 'id' => $alias->getId()]);
                }

                // Redirect to "index" page
                return $this->redirect()->toRoute('alias', ['action' => 'index']);
            }
        }

        return new ViewModel([
            'form' => $form
        ]);

    }

    /**
     * @return void|\Zend\Http\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction()
    {

        $id = $this->params()->fromRoute('id', NULL);

        if ($id === NULL) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $alias = $this->entityManager->getRepository(Alias::class)->find($id);

        if ($alias === NULL) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->entityManager->remove($alias);

        $this->entityManager->flush();

        return $this->redirect()->toRoute('alias', ['action' => 'index']);

    }

}