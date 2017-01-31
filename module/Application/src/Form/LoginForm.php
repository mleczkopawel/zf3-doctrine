<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 15:12
 */

namespace Application\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name = 'loginUser');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'options' => array(
                'label' => 'Email Użytkonika',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'Hasło',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'createSubmit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Zaloguj',
                'class' => 'btn btn-primary btn-block',
                'style' => 'margin-top: 2%',
            )
        ));
    }
}