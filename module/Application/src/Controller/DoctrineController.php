<?php

namespace Application\Controller;

use Application\Entity\Album;
use Application\Interfaces\CreateEntity;
use Doctrine\ORM\EntityManager;
use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DoctrineController extends AbstractActionController
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function indexAction()
    {
        $album = (new CreateEntity())->create('Album');
//        if ($album) {
            $album->setName('nazwa5');
            $album->setCreatedAt(new \DateTime(date('d.m.Y')));

            $this->em->persist($album);
            $this->em->flush();
//        } else {
//            throw new Exception('Nie można utworzyć!');
//        }

        return new ViewModel([
            'albums' => $this->em->getRepository(Album::class)->findAll(),
        ]);
    }
}
