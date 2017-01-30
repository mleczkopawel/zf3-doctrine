<?php

namespace Application\Controller;

use Application\Entity\Album;
use Application\Factory\CreateEntityFactory;
use Application\Service\OAuthService;
use Doctrine\ORM\EntityManager;
use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class DoctrineController
 * @package Application\Controller
 */
class DoctrineController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $_em;
    /**
     * @var CreateEntityFactory
     */
    private $_cef;

    /**
     * DoctrineController constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
        $this->_cef = new CreateEntityFactory();
    }

    /**
     * @return ViewModel
     * @throws Exception
     */
    public function indexAction()
    {
        $album = $this->_cef->create(Album::class);
        if ($album) {
            $album->setName('nazwa5555');
            $album->setDateAdd(new \DateTime(date('d.m.Y')));

            $this->_em->persist($album);
            $this->_em->flush();
        } else {
            throw new Exception('Nie można utworzyć!');
        }

        return new ViewModel([
            'albums' => $this->_em->getRepository(Album::class)->findAll(),
        ]);
    }
}
