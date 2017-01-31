<?php
/**
 * User: mlecz
 * Date: 31.01.2017
 * Time: 10:50
 */

namespace Application\Form;

use Zend\Form\Form;

/**
 * Class RegisterForm
 * @package Application\Form
 */
class RegisterForm extends Form
{
    /**
     * RegisterForm constructor.
     * @param int|null|string $translator
     * @param null $name
     */
    public function __construct($translator, $locale, $name = null)
    {
        parent::__construct($name = 'createUser');
        $this->setAttribute('method', 'post');

        echo $translator->translate('Email Użytkonika', 'default', $locale);die;

        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => $translator->translate('Email Użytkonika', 'default', $locale),
            ],
            'attributes' => [
                'placeholder' => 'Email Użytkonika',
                'class' => 'form-control',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Hasło',
            ],
            'attributes' => [
                'placeholder' => 'Hasło',
                'class' => 'form-control',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'spassword',
            'type' => 'password',
            'options' => [
                'label' => 'Powtórz Hasło',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Powtórz Hasło',
                'required' => true,
            ],
        ]);


        $this->add([
            'type' => 'captcha',
            'name' => 'capt',
            'options' => [
                'label' => 'Jesteś człowiekiem?',
                'captcha' => [
                    'class' => 'Dumb',
                    'wordLen' => 6,
                    'expiration' => 600,
                ],
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => true,
            ]
        ]);

        $this->add([
            'name' => 'createSubmit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Zarejestruj',
                'class' => 'btn btn-primary btn-block',
                'style' => 'margin-top: 2%',
            ]
        ]);
    }
}