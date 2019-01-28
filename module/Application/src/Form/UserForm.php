<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;

use Application\Entity\User;

/**
 * This form is used to collect vendors information. The form
 * can work in two scenarios - 'create' and 'update'.
 */
class UserForm extends Form
{

    /**
     * Scenario ('create' or 'update').
     * @var string
     */
    private $scenario;

    private $domains;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'create', $domains)
    {

        // Define form name
        parent::__construct('form-contact-add');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;

        $this->domains = $domains;

        $this->addElements();

        $this->addInputFilter();

    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {

        // Add "id" field
        $this->add([
            'type' => 'text',
            'name' => 'id',
            'attributes' => [
                'id' => 'id',
                'autocomplete' => 'off',
            ],
            'options' => [
                'label' => 'Id',
            ]
        ]);

        // Add "domain" field
        $select = new Element\Select('domain');
        $select->setLabel('Domain');
        $valueOptions = array();
        foreach ($this->domains as $domain) {
            $valueOptions[$domain->getId()] = $domain->getName();
        }
        $select->setValueOptions($valueOptions);
        $select->setAttribute('id', 'domain');
        $this->add($select);

        // Add "username" field
        $this->add([
            'type' => 'text',
            'name' => 'username',
            'attributes' => [
                'id' => 'username',
                'autocomplete' => 'off'
            ],
            'options' => [
                'label' => 'Username',
            ]
        ]);

        // Add "password" field
        $this->add([
            'type' => 'password',
            'name' => 'password',
            'attributes' => [
                'id' => 'password',
                'autocomplete' => 'off',
            ],
            'options' => [
                'label' => 'Password',
            ]
        ]);

        // Add "status" field
        $select = new Element\Select('status');
        $select->setLabel('Status');
        $user = new User();
        $valueOptions = $user->getStatusList();
        $select->setValueOptions($valueOptions);
        $select->setAttribute('id', 'status');
        $this->add($select);

        // button
        $buttons = array(
            'save',
            'save_and_edit',
            'cancel'
        );
        foreach ($buttons as $name)
        {

            $value = $name;
            $value = preg_replace('/_/', ' ', $value);
            $value = ucwords($value);
            $this->add([
                'type' => 'submit',
                'name' => $name,
                'attributes' => [
                    'value' => $value
                ],
                'options' => [
                    'label' => $value
                ]
            ]);

        }

    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {

        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $form_fields = array(
            'domain' => true,
            'username' => true,
            'password' => false,
            'status' => true,
        );

        foreach ($form_fields as $name => $required)
        {
            $inputFilter->add([
                'name' => $name,
                'required' => $required
            ]);
        }

    }

}
