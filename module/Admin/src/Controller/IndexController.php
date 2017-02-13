<?php
/**
 * User: Paweł Mleczko
 * Date: 13.02.2017
 * Time: 20:30
 */

namespace Admin\Controller;


use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Admin\Controller
 */
class IndexController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    private $_em;

    /**
     * IndexController constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
    }

    private function template() {
        $this->layout('admin/layout');
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $this->template();
        return new ViewModel();
    }

}