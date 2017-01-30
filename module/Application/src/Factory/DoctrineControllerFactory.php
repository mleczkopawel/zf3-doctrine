<?php

namespace Application\Factory;

use Application\Controller\DoctrineController;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class DoctrineControllerFactory
 * @package Application\Controller
 */
class DoctrineControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return DoctrineController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get(EntityManager::class);

        return new DoctrineController($em);
    }
}
