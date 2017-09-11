<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 11.09.17
 * Time: 14:13
 */

namespace Application\Form;


use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class RoomForm
 * @package Application\Form
 */
class RoomForm extends Form
{
    /**
     * RoomForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        parent::__construct($name = 'room');
    }

    public function init() {
        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Nazwa pokoju',
            ],
            'attributes' => [
                'placeholder' => 'Nazwa pokoju',
                'class' => 'form-control',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'type',
            'type' => Select::class,
            'options' => [
                'label' => 'Typ pokoju',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => true,
            ],
        ]);

        $this->add(array(
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => array(
                'value' => 'Zapisz',
                'class' => 'btn btn-primary',
                'style' => 'position: absolute; right: 30px; bottom: 30px;',
                'id' => 'submit',
            )
        ));
    }

}