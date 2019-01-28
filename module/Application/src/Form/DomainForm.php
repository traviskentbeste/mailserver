<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * This form is used to collect vendors information. The form
 * can work in two scenarios - 'create' and 'update'.
 */
class DomainForm extends Form
{

    /**
     * Scenario ('create' or 'update').
     * @var string
     */
    private $scenario;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'create')
    {

        // Define form name
        parent::__construct('form-contact-add');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;

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

        // Add "name" field
        $this->add([
            'type' => 'text',
            'name' => 'name',
            'attributes' => [
                'id' => 'name',
                'autocomplete' => 'off',
            ],
            'options' => [
                'label' => 'Name',
            ]
        ]);

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
            'name' => true,
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
