<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\ViewModel;

use Application\Form\UserForm;
use Application\Entity\User;
use Application\Entity\Domain;

class UserController extends AbstractActionController
{

    /**
     * Entity manager.cc
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $userManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $userManager)
    {

        $this->entityManager = $entityManager;
        $this->userManager = $userManager;

    }

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {

        $users = $this->entityManager->getRepository(User::class)->findAll();

        return new ViewModel([
            'users' => $users
        ]);

    }

    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function addAction()
    {

        $domains = $this->entityManager->getRepository(Domain::class)->findAll();
        $form = new UserForm('create', $domains);
        $form->bind(new User());

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
                return $this->redirect()->toRoute('user', ['action' => 'index']);
            }

            // set data in to the form
            $form->setData($formDataRaw);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $user = $form->getData();

                // wrap this all in a transaction
                $this->entityManager->getConnection()->beginTransaction();

                try {

                    // set the domain
                    $domain = $this->entityManager->getRepository(Domain::class)->find($formDataRaw['domain']);
                    $user->setDomain($domain);

                    // set the password
                    $salt = substr(sha1(rand()), 0, 16);
                    $hashedPassword = crypt($formDataRaw['password'], "$6$$salt");
                    $user->setPassword($hashedPassword);

                    $this->userManager->add($user);

                    $this->entityManager->getConnection()->commit();

                } catch (Exception $e) {

                    // rollback
                    $this->entityManager->getConnection()->rollBack();

                    throw $e;
                }

                // Redirect to "edit" page
                if (isset($formDataRaw['save_and_edit']) && ($formDataRaw['save_and_edit'] == 'Save And Edit')) {
                    return $this->redirect()->toRoute('user', ['action' => 'edit', 'id' => $user->getId()]);
                }

                // Redirect to "index" page
                return $this->redirect()->toRoute('user', ['action' => 'index']);
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
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if ($user === NULL) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $domains = $this->entityManager->getRepository(Domain::class)->findAll();
        $form = new UserForm('create', $domains);
        $form->bind($user);

        // need to save this
        $password = $user->getPassword();

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
                return $this->redirect()->toRoute('user', ['action' => 'index']);
            }

            // set data in to the form
            $form->setData($formDataRaw);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $user = $form->getData();

                // wrap this all in a transaction
                $this->entityManager->getConnection()->beginTransaction();

                try {

                    // set the domain
                    if ( isset($formDataRaw['domain']) && ($formDataRaw['domain'] != '') ) {
                        $domain = $this->entityManager->getRepository(Domain::class)->find($formDataRaw['domain']);
                        $user->setDomain($domain);
                    }

                    // set the password
                    if ( isset($formDataRaw['password']) && ($formDataRaw['password'] != '') ) {
                        $salt = substr(sha1(rand()), 0, 16);
                        $hashedPassword = crypt($formDataRaw['password'], "$6$$salt");
                        $user->setPassword($hashedPassword);
                    } else {
                        // reset the password if they don't supply it
                        $user->setPassword($password);
                    }

                    $this->userManager->update($user);

                    $this->entityManager->getConnection()->commit();

                } catch (Exception $e) {

                    // rollback
                    $this->entityManager->getConnection()->rollBack();

                    throw $e;
                }

                // Redirect to "edit" page
                if (isset($formDataRaw['save_and_edit']) && ($formDataRaw['save_and_edit'] == 'Save And Edit')) {
                    return $this->redirect()->toRoute('user', ['action' => 'edit', 'id' => $user->getId()]);
                }

                // Redirect to "index" page
                return $this->redirect()->toRoute('user', ['action' => 'index']);
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

        $user = $this->entityManager->getRepository(User::class)->find($id);

        if ($user === NULL) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->entityManager->remove($user);

        $this->entityManager->flush();

        return $this->redirect()->toRoute('user', ['action' => 'index']);

    }

}