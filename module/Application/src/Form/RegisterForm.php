<?php
/**
 * User: mlecz
 * Date: 31.01.2017
 * Time: 10:50
 */

namespace Application\Form;

use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
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
    public function __construct($translator, $name = null)
    {
        parent::__construct($name = 'createUser');
        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'email',
            'type' => Text::class,
            'options' => [
                'label' => $translator->translate('Email użytkownika', 'default', LOCALE),
            ],
            'attributes' => [
                'placeholder' => $translator->translate('Email użytkownika', 'default', LOCALE),
                'class' => 'form-control js-email',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'password',
            'type' => Password::class,
            'options' => [
                'label' => $translator->translate('Hasło', 'default', LOCALE),
            ],
            'attributes' => [
                'placeholder' => $translator->translate('Hasło', 'default', LOCALE),
                'class' => 'form-control js-pass',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'spassword',
            'type' => Password::class,
            'options' => [
                'label' => $translator->translate('Powtórz hasło', 'default', LOCALE),
            ],
            'attributes' => [
                'class' => 'form-control js-spass',
                'placeholder' => $translator->translate('Powtórz hasło', 'default', LOCALE),
                'required' => true,
            ],
        ]);


        $this->add([
            'type' => 'captcha',
            'name' => 'capt',
            'options' => [
                'label' => $translator->translate('Potwierdź czy jesteś człowiekiem, wpisując teskt z obrazka.', 'default', LOCALE),
                'captcha' => [
                    'class' => 'Figlet',
                    'wordLen' => 4,
                    'expiration' => 600,
                    'messages' => [
                        'badCaptcha' => $translator->translate('Niepoprawny tekst, wpisz jeszcze raz.', 'default', LOCALE),
                    ],
                ],
            ],
            'attributes' => [
                'class' => 'form-control js-capt',
                'placeholder' => $translator->translate('Tekst z obrazka', 'default', LOCALE),
                'required' => true,
            ]
        ]);

        $this->add([
            'name' => 'createSubmit',
            'type' => Submit::class,
            'attributes' => [
                'value' => $translator->translate('Zarejestruj', 'default', LOCALE),
                'class' => 'btn btn-primary btn-block js-sub',
                'style' => 'margin-top: 2%',
            ]
        ]);
    }
}