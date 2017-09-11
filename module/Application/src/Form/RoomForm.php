<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 11.09.17
 * Time: 14:13
 */

namespace Application\Form;


use Zend\Form\Element\Text;
use Zend\Form\Form;

class RoomForm extends Form
{
    public function __construct($name = null) {
        parent::__construct($name = 'room');
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


    }

}