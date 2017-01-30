<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 14:36
 */

namespace Application\Controller;


use Application\Entity\User;
use Application\Factory\CreateEntityFactory;
use Application\Form\LoginForm;
use Application\Service\OAuthService;
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

    private $_cef;

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
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $oFAuth = new OAuthService();
        $oFAuth->getProvider('fb');
        $url = $oFAuth->generateAuthButton();

        $form = new LoginForm();

        $request = $this->getRequest();

        if ($request->isPost() || (isset($_GET['code']) && $_GET['code'] != null)) {
            if (!isset($_GET['code'])) {
                $data = $request->getPost();
                $adapter = $this->_as->getAdapter();
                $adapter->setIdentity($data['name']);
                $adapter->setCredential($data['password']);
                $authResult = $adapter->authenticate();
                $authResult = $authResult->getIdentity();
                $test = true;
            } else {
                $auth = $oFAuth->oAuthorize();
                $user = $this->_em->getRepository(User::class)->findBy(['name' => $auth['user']->getName(), 'facebook' => 1]);
                if (!$user) {
                    $user = $this->_cef->create(User::class);
                    $user->setName($auth['user']->getName());
                    $user->setFacebook('1');
                    $user->setPassword('zzaaqqq');
                    $user->setDateAdd(new \DateTime());
                    $user->setDateEdit(new \DateTime());
                    $this->_em->persist($user);
                    $this->_em->flush();
                }
                $authResult = $auth['user'];
                $test = true;
            }
            if ($test) {
                $session = new Container('User');
                $session->offsetSet('name', $authResult->getName());
                $this->redirect()->toRoute('application');
            }
        }

        return new ViewModel([
            'form' => $form,
            'url' => $url,
        ]);
    }
}