<?php
/**
 * User: mlecz
 * Date: 07.02.2017
 * Time: 13:10
 */

namespace Cron\Controller;

use Application\Entity\User;
use Application\Functions\TokenGenerator;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;

class CronController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $_em;

    /**
     * CronController constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
    }


    public function indexAction()
    {
        var_dump('asfasdfsdf');
    }

    public function updateTokensAction() {
        $users = $this->_em->getRepository(User::class)->findAll();
        foreach ($users as $user) {
            echo $user->getId() . ', ' . $user->getToken();
            $token = (new TokenGenerator())->string(30);
            $user->setToken($token);
            $this->_em->persist($user);
        }
        $this->_em->flush();
        die;
    }

}