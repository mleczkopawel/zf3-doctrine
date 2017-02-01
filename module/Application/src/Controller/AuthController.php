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
use Application\Filter\RegisterFilter;
use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Application\Functions\TokenGenerator;
use Application\Functions\UserPassword;
use Application\Service\MailService;
use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;
use Zend\I18n\Translator\Translator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
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
     * @var Translator
     */
    private $_translator;

    /**
     * AuthController constructor.
     * @param AuthenticationService $as
     * @param EntityManager $em
     */
    public function __construct(AuthenticationService $as, EntityManager $em)
    {
        $this->_as = $as;
        $this->_em = $em;
        $this->_cef = new CreateEntityFactory();
        $this->_translator = new Translator();
    }

//    TODO: cookies
//    TODO: regulamin

    /**
     *
     */
    public function indexAction()
    {
        $this->redirect()->toRoute('auth/login', ['locale' => LOCALE]);
    }

    /**
     * @return ViewModel
     */
    public function loginAction() {
        $this->_translator->addTranslationFile('gettext', ROOT_PATH . '/module/Application/language/' . LOCALE . '.mo');
        $facebook = (new OAuthServiceFactory())->create('fb');
        $google = (new OAuthServiceFactory())->create('google');

        $urlF = $facebook->generateAuthButton();
        $urlG = $google->generateAuthButton();

        $form = new LoginForm($this->_translator, null);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $password = (new UserPassword())->create($data['password']);

            $adapter = $this->_as->getAdapter();
            $adapter->setIdentity($data['name']);
            $adapter->setCredential($password);
            $authResult = $adapter->authenticate();
            if ($authResult->getCode() == 1) {
                $authResult = $authResult->getIdentity();
                if ($authResult->isIsActive()) {
                    $this->setSession($authResult);
                } else {
                    $this->redirect()->toRoute('application', ['locale' => LOCALE]);
                }
            } else {
                $this->redirect()->toRoute('application', ['locale' => LOCALE]);
            }
        }

        return new ViewModel([
            'form' => $form,
            'urlF' => $urlF,
            'urlG' => $urlG,
            'messages' => $this->flashMessenger()->getMessages(),
        ]);
    }

    /**
     * @return ViewModel
     */
    public function registerAction() {
        $this->_translator->addTranslationFile('gettext', ROOT_PATH . '/module/Application/language/' . LOCALE . '.mo');
        $form = new RegisterForm($this->_translator,  null);
        $filter = new RegisterFilter();
        $filter->setTranslator($this->_translator);
        $request = $this->getRequest();

        $form->setInputFilter($filter->getInputFilter());

        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $user = $this->_em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
                if (!$user) {
                    $user = $this->_cef->create(User::class);
                } elseif ($user->getGoogle() || $user->getFacebook()) {

                } else {
//                    TODO: zrobić reset hasła
                    var_dump('Istnieje!!!');die;
                }
                $password = (new UserPassword())->create($data['password']);
                $token = (new TokenGenerator())->string(30);
                $user->setEmail($data['email']);
                $user->setPassword($password);
                $user->setDateAdd(new \DateTime());
                $user->setProvider('local');
                $user->setIsActive(0);
                $user->setToken($token);

                $this->_em->persist($user);
                $this->_em->flush();

                $dataSend = [
                    'id' => $user->getId(),
                    'email' => $data['email'],
                    'token' => $token,
                ];

                $mailService = new MailService();
                $mailService->send($dataSend, $this->_translator);

                $this->flashMessenger()->addMessage($this->_translator->translate('Zarejestrowano, proszę sprawdzić maila.', 'default', LOCALE));
                $this->redirect()->toRoute('application', ['locale' => LOCALE]);
            }
        }


        return new ViewModel([
            'form' => $form,
            'messages' => $this->flashMessenger()->getMessages(),
        ]);
    }

    /**
     *
     */
    public function callbackAction() {
        $provider = $this->params()->fromRoute('provider');
        switch ($provider) {
            case 'fb': {
                $facebook = (new OAuthServiceFactory())->create('fb');
                $auth = $facebook->oAuthorize();
                $provider = 'facebook';
            } break;
            case 'google': {
                $google = (new OAuthServiceFactory())->create('google');
                $auth = $google->oAuthorize();
            } break;
        }
        $user = $this->_em->getRepository(User::class)->findOneBy(['email' => $auth['user']->getEmail()]);
        if (!$user) {
            $password = (new UserPassword())->create(date('d.m.Y H:i:s'));
            $token = (new TokenGenerator())->string(30);
            $user = $this->_cef->create(User::class);
            $user->setPassword($password);
            $user->setDateAdd(new \DateTime());
            $user->setEmail($auth['user']->getEmail());
            $user->setToken($token);
        }
        $user->setName($auth['user']->getName());
        $user->setIsActive(true);
        $user->setProvider($provider);
        if ($provider == 'facebook') {
            echo '<img src="'.$auth['user']->getPictureUrl().'" />';die;
        } elseif ($provider == 'google') {
            echo '<img src="'.$auth['user']->getAvatar().'" />';die;
        }

        $this->_em->persist($user);
        $this->_em->flush();

        $this->setSession($auth['user']);
    }

    /**
     * @param $authResult
     */
    private function setSession($authResult) {
        $user = $this->_em->getRepository(User::class)->findOneBy(['email' => $authResult->getEmail()]);
        $user->setDateLastLogin(new \DateTime());
        $this->_em->persist($user);
        $this->_em->flush();
        $session = new Container('User');
        $session->offsetSet('name', $authResult->getName());
        $this->flashMessenger()->addMessage($this->_translator->translate('Zalogowano jako ', 'default', LOCALE) . '<b>' . $authResult->getName() . '</b>');
        $this->redirect()->toRoute('application', ['locale' => LOCALE]);
    }

    /**
     *
     */
    public function logoutAction() {
        $this->_as->clearIdentity();

        $session = new Container('User');
        $session->getManager()->getStorage()->clear('User');
        $this->flashMessenger()->addMessage($this->_translator->translate('Wylogowano', 'default', LOCALE));
        $this->redirect()->toRoute('auth/login', ['locale' => LOCALE]);
    }

    /**
     *
     */
    public function checkAction() {
        $id = $this->params()->fromRoute('id');
        $token = $this->params()->fromRoute('token');
        $user = $this->_em->getRepository(User::class)->findOneBy(['id' => $id, 'token' => $token]);
        $user->setIsActive(1);

        $this->_em->persist($user);
        $this->_em->flush();
        $this->flashMessenger()->addMessage($this->_translator->translate('Zaakceptowano, teraz możesz się zalogować ', 'default', LOCALE) . '<b>' . $user->getName() . '</b>');
        $this->redirect()->toRoute('auth/login', ['locale' => LOCALE]);
    }

    public function resetPasswordAction() {

    }
}