<?php
/**
 * User: Paweł Mleczko
 * Date: 13.02.2017
 * Time: 20:31
 */

namespace Admin\Factory;

use Admin\Controller\IndexController;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class DoctrineControllerFactory
 * @package Admin\Factory
 */
class DoctrineControllerFactory implements FactoryInterface
{


    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return IndexController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get(EntityManager::class);

        return new IndexController($em);
    }
}