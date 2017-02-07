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
     * @param array $required
     * @param null $name
     */
    public function __construct($translator, $required = [], $name = null)
    {
        parent::__construct($name = 'loginUser');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'email',
            'type' => Text::class,
            'options' => array(
                'label' => $translator->translate('Email użytkownika', 'default', LOCALE),
            ),
            'attributes' => array(
                'placeholder' => $translator->translate('Email użytkownika', 'default', LOCALE),
                'class' => 'form-control',
                'required' => $required['name'],
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
                'id' => 'password',
                'class' => 'form-control',
                'required' => $required['pass'],
            ),
        ));

        $this->add([
            'name' => 'spassword',
            'type' => Password::class,
            'options' => [
                'label' => $translator->translate('Powtórz hasło', 'default', LOCALE),
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => $translator->translate('Powtórz hasło', 'default', LOCALE),
                'required' => $required['pass'],
            ],
        ]);

        $this->add(array(
            'name' => 'createSubmit',
            'type' => Submit::class,
            'attributes' => array(
                'value' => $translator->translate('Zaloguj', 'default', LOCALE),
                'class' => 'btn btn-primary btn-block',
                'style' => 'margin-top: 2%',
                'id' => 'submit',
            )
        ));
    }
}