<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\ViewModel;

use Application\Form\DomainForm;
use Application\Entity\Domain;

class DomainController extends AbstractActionController
{

    /**
     * Entity manager.cc
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $domainManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $domainManager)
    {

        $this->entityManager = $entityManager;
        $this->domainManager = $domainManager;

    }

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {

        $domains = $this->entityManager->getRepository(Domain::class)->findAll();

        return new ViewModel([
            'domains' => $domains
        ]);

    }

    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function addAction()
    {

        $form = new DomainForm('create');
        $form->bind(new Domain());

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
                return $this->redirect()->toRoute('domain', ['action' => 'index']);
            }

            // set data in to the form
            $form->setData($formDataRaw);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $domain = $form->getData();

                // wrap this all in a transaction
                $this->entityManager->getConnection()->beginTransaction();

                try {

                    $this->domainManager->add($domain);

                    $this->entityManager->getConnection()->commit();

                } catch (Exception $e) {

                    // rollback
                    $this->entityManager->getConnection()->rollBack();

                    throw $e;
                }

                // Redirect to "edit" page
                if (isset($formDataRaw['save_and_edit']) && ($formDataRaw['save_and_edit'] == 'Save And Edit')) {
                    return $this->redirect()->toRoute('domain', ['action' => 'edit', 'id' => $domain->getId()]);
                }

                // Redirect to "index" page
                return $this->redirect()->toRoute('domain', ['action' => 'index']);
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
        $domain = $this->entityManager->getRepository(Domain::class)->find($id);

        if ($domain === NULL) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new DomainForm('create');
        $form->bind($domain);

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
                return $this->redirect()->toRoute('domain', ['action' => 'index']);
            }

            // set data in to the form
            $form->setData($formDataRaw);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $domain = $form->getData();

                // wrap this all in a transaction
                $this->entityManager->getConnection()->beginTransaction();

                try {

                    $this->domainManager->update($domain);

                    $this->entityManager->getConnection()->commit();

                } catch (Exception $e) {

                    // rollback
                    $this->entityManager->getConnection()->rollBack();

                    throw $e;
                }

                // Redirect to "edit" page
                if (isset($formDataRaw['save_and_edit']) && ($formDataRaw['save_and_edit'] == 'Save And Edit')) {
                    return $this->redirect()->toRoute('domain', ['action' => 'edit', 'id' => $domain->getId()]);
                }

                // Redirect to "index" page
                return $this->redirect()->toRoute('domain', ['action' => 'index']);
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

        $domain = $this->entityManager->getRepository(Domain::class)->find($id);

        if ($domain === NULL) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->entityManager->remove($domain);

        $this->entityManager->flush();

        return $this->redirect()->toRoute('domain', ['action' => 'index']);

    }

}