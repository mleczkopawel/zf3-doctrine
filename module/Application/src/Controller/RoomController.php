<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 11.09.17
 * Time: 13:33
 */

namespace Application\Controller;


use Application\Entity\Room;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class RoomController
 * @package Application\Controller
 */
class RoomController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $_em;

    /**
     * RoomController constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->_em = $entityManager;
    }

    public function indexAction() {
        $rooms = $this->_em->getRepository(Room::class)->findAll();
        return new ViewModel([
            'rooms' => $rooms
        ]);
    }

    public function editAction() {

    }
}