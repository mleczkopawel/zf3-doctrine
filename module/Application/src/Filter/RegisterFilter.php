<?php
/**
 * User: mlecz
 * Date: 31.01.2017
 * Time: 13:25
 */

namespace Application\Filter;

use Exception;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\Hostname;
use Zend\Validator\Identical;
use Zend\Validator\StringLength;

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
     * @var
     */
    private $_translator;

    /**
     * @return mixed
     */
    public function getTranslator()
    {
        return $this->_translator;
    }

    /**
     * @param mixed $translator
     * @return RegisterFilter
     */
    public function setTranslator($translator)
    {
        $this->_translator = $translator;
        return $this;
    }

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
        $strinLengthMessages = [
            StringLength::TOO_SHORT => $this->_translator->translate('Wprowadź minimum %min% znaków.', 'default', LOCALE),
            StringLength::TOO_LONG => $this->_translator->translate('Wprowadź maximum %max% znaków.', 'default', LOCALE),
            StringLength::INVALID => $this->_translator->translate('Nieprawidłowy typ, oczekiwałem ciągu znaków.', 'default', LOCALE),
        ];
        if (!$this->_inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name' => 'email',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 8,
                            'max' => 50,
                            'messages' => $strinLengthMessages,
                        ],
                    ],
                    [
                        'name' => EmailAddress::class,
                        'options' => [
                            'messages' => [
                                EmailAddress::INVALID => $this->_translator->translate('Nieprawidłowy typ, oczekiwałem ciągu znaków.', 'default', LOCALE),
                                EmailAddress::INVALID_FORMAT => $this->_translator->translate('Nieprawidłowy adres email, użyj NAZWA@NAZWA_HOSTA.', 'default', LOCALE),
                                EmailAddress::INVALID_HOSTNAME => $this->_translator->translate('%hostname% nie jest właściwą nazwą hosta dla adresu email.', 'default', LOCALE),
                                EmailAddress::INVALID_MX_RECORD => $this->_translator->translate('%hostname% wydaje się nie mieć ważnego MX lub adresu email.', 'default', LOCALE),
                                EmailAddress::INVALID_SEGMENT => $this->_translator->translate('%hostname% wydaje się nie routowalny, nie może być rozwiązany w sieci.', 'default', LOCALE),
                                EmailAddress::DOT_ATOM => $this->_translator->translate('%localPart% nie może być powiązany z niczym kropką.', 'default', LOCALE),
                                EmailAddress::QUOTED_STRING => $this->_translator->translate('%localPart% nie może być w apostrofach.', 'default', LOCALE),
                                EmailAddress::INVALID_LOCAL_PART => $this->_translator->translate('%localPart% nieprawidłowa część lokalna adresu email.', 'default', LOCALE),
                                Hostname::CANNOT_DECODE_PUNYCODE => $this->_translator->translate('Nieprawidłowy punnycode.', 'default', LOCALE),
                                Hostname::INVALID => $this->_translator->translate('Nieprawidłowy typ, oczekiwałem ciągu znaków.', 'default', LOCALE),
                                Hostname::INVALID_DASH => $this->_translator->translate('Nazwa hosta wydaje się być prawdłowa, lecz slash jest w nieprawidłowej pozycji.', 'default', LOCALE),
                                Hostname::INVALID_HOSTNAME => $this->_translator->translate('Nieprawidłowy adres hosta, nie można odnaleźć danego hosta.', 'default', LOCALE),
                                Hostname::INVALID_HOSTNAME_SCHEMA => $this->_translator->translate('Nie poprawny schemat TLD %tld%.', 'default', LOCALE),
                                Hostname::INVALID_LOCAL_NAME => $this->_translator->translate('Wpisany lokalny adres sieci, lokalne adresy sieciowe nie są akceptowane.', 'default', LOCALE),
                                Hostname::INVALID_URI => $this->_translator->translate('Niepoprawny adres URI.', 'default', LOCALE),
                                Hostname::UNKNOWN_TLD => $this->_translator->translate('Nie potrafię rozpoznać adresu.', 'default', LOCALE),
                            ]
                        ]
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'password',
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 8,
                            'max' => 250,
                            'messages' => $strinLengthMessages,
                        ],
                    ],
                ],
            ]);

            $inputFilter->add([
                'name' => 'spassword',
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 8,
                            'max' => 250,
                            'messages' => $strinLengthMessages,
                        ],
                    ],
                    [
                        'name' => Identical::class,
                        'options' => [
                            'token' => 'password',
                            'messages' => [
                                Identical::NOT_SAME => $this->_translator->translate('Wpisane hasła nie są identyczne.', 'default', LOCALE),
                                Identical::MISSING_TOKEN => $this->_translator->translate('Hasło nie zostało wpisane.', 'default', LOCALE),
                            ],
                        ],
                    ],
                ],
            ]);

            $this->_inputFilter = $inputFilter;
        }

        return $this->_inputFilter;
    }
}