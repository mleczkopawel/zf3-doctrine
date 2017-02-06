<?php
/**
 * User: Paweł Mleczko
 * Date: 06.02.2017
 * Time: 22:08
 */

namespace Application\Form;


use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class ResetForm extends Form
{
    public function __construct($translator, $name = null)
    {
        parent::__construct($name = 'reset');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'name',
            'type' => Text::class,
            'options' => array(
                'label' => $translator->translate('Email użytkownika', 'default', LOCALE),
            ),
            'attributes' => array(
                'placeholder' => $translator->translate('Email użytkownika', 'default', LOCALE),
                'class' => 'form-control',
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'createSubmit',
            'type' => Submit::class,
            'attributes' => array(
                'value' => $translator->translate('Wyślij email', 'default', LOCALE),
                'class' => 'btn btn-primary btn-block',
                'style' => 'margin-top: 2%',
            )
        ));
    }
}