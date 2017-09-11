<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 11.09.17
 * Time: 13:34
 */

namespace Application\Factory;

use Application\Controller\RoomController;
use Application\Form\RoomForm;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class RoomFactory
 * @package Application\Factory
 */
class RoomFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return RoomController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get(EntityManager::class);
        $formManager = $container->get('FormElementManager');
        $roomForm = $formManager->get(RoomForm::class);

        return new RoomController($em, $roomForm);
    }
}