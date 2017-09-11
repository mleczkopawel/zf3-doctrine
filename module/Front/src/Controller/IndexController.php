<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 11.09.17
 * Time: 13:21
 */

namespace Front\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function __construct()
    {
    }

    public function indexAction() {
        $this->layout('front/layout');
        return new ViewModel();
    }
}