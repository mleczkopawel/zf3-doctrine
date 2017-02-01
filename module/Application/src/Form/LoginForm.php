<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 15:12
 */

namespace Application\Form;

use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class LoginForm
 * @package Application\Form
 */
class LoginForm extends Form
{
    /**
     * LoginForm constructor.
     * @param int|null|string $translator
     * @param null $name
     */
    public function __construct($translator, $name = null)
    {
        parent::__construct($name = 'loginUser');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'name',
            'type' => Text::class,
            'options' => array(
                'label' => $translator->translate('Email użytkonika', 'default', LOCALE),
            ),
            'attributes' => array(
                'placeholder' => $translator->translate('Email użytkonika', 'default', LOCALE),
                'class' => 'form-control',
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'type' => Password::class,
            'options' => array(
                'label' => $translator->translate('Hasło', 'default', LOCALE),
            ),
            'attributes' => array(
                'placeholder' => $translator->translate('Hasło', 'default', LOCALE),
                'class' => 'form-control',
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'createSubmit',
            'type' => Submit::class,
            'attributes' => array(
                'value' => $translator->translate('Zaloguj', 'default', LOCALE),
                'class' => 'btn btn-primary btn-block',
                'style' => 'margin-top: 2%',
            )
        ));
    }
}