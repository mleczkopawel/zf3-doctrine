<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 11.09.17
 * Time: 14:46
 */

namespace Application\Factory;


use Application\Form\RoomForm;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class RoomFormFactory
 * @package Application\Factory
 */
class RoomFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return RoomForm
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new RoomForm();
    }

}