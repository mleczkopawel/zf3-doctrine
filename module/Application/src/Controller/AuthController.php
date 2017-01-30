<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 14:36
 */

namespace Application\Controller;


use Application\Entity\User;
use Application\Factory\CreateEntityFactory;
use Application\Factory\OAuthServiceFactory;
use Application\Form\LoginForm;
use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * Class AuthController
 * @package Application\Controller
 */
class AuthController extends AbstractActionController
{

    /**
     * @var AuthenticationService
     */
    private $_as;

    /**
     * @var EntityManager
     */
    private $_em;

    /**
     * @var CreateEntityFactory
     */
    private $_cef;

    /**
     * @var OAuthServiceFactory
     */
    private $_oasfF;

    /**
     * @var OAuthServiceFactory
     */
    private $_oasfG;

    /**
     * AuthController constructor.
     * @param AuthenticationService $as
     * @param EntityManager $em
     */
    public function __construct(AuthenticationService $as,EntityManager $em)
    {
        $this->_as = $as;
        $this->_em = $em;
        $this->_cef = new CreateEntityFactory();
        $this->_oasfF = new OAuthServiceFactory();
        $this->_oasfG = new OAuthServiceFactory();
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $this->_oasfF->create('fb');
        $this->_oasfG->create('google');

        $urlF = $this->_oasfF->generateAuthButton();
        $urlG = $this->_oasfG->generateAuthButton();

        $form = new LoginForm();

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost();
            $adapter = $this->_as->getAdapter();
            $adapter->setIdentity($data['name']);
            $adapter->setCredential($data['password']);
            $authResult = $adapter->authenticate();
            $authResult = $authResult->getIdentity();


            $this->setSession($authResult);
        }

        return new ViewModel([
            'form' => $form,
            'urlF' => $urlF,
            'urlG' => $urlG,
        ]);
    }

    public function callbackAction() {
        $provider = $this->params()->fromRoute('provider');
        switch ($provider) {
            case 'fb': {
                $auth = $this->_oasfF->oAuthorize();
                $provider = 'facebook';
            } break;
            case 'google': {
                $auth = $this->_oasfG->oAuthorize();
            } break;
        }
        $user = $this->_em->getRepository(User::class)->findBy(['name' => $auth['user']->getName(), 'email' => $auth['user']->getEmail()]);
        if (!$user) {
            $user = $this->_cef->create(User::class);
        }
        $user->setName($auth['user']->getName());
        $user->setPassword('zaqwsx');
        $user->setDateAdd(new \DateTime());
        $user->setDateEdit(new \DateTime());
    }

    /**
     * @param $authResult
     */
    private function setSession($authResult) {
        $session = new Container('User');
        $session->offsetSet('name', $authResult->getName());
        $this->redirect()->toRoute('application');
    }
}