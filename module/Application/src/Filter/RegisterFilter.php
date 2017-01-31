<?php
/**
 * User: mlecz
 * Date: 31.01.2017
 * Time: 13:25
 */

namespace Application\Filter;


use Exception;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class RegisterFilter
 * @package Application\Filter
 */
class RegisterFilter implements InputFilterAwareInterface
{

    /**
     * @var
     */
    protected $_inputFilter;

    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     * @throws Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new Exception("Not used");
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->_inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name' => 'email',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 250,
                        ],
                    ],
                    [
                        'name' => 'EmailAddress',
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'password',
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 8,
                            'max' => 250,
                        ],
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'spassword',
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 8,
                            'max' => 250,
                        ],
                    ],
                    [
                        'name' => 'Identical',
                        'options' => [
                            'token' => 'password',
                        ],
                    ],
                ],
            ]);

            $this->_inputFilter = $inputFilter;
        }

        return $this->_inputFilter;
    }
}