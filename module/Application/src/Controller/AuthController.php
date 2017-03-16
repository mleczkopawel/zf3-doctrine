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
//    TODO: zapisywanie avatarów
//    TODO: dopracować tłumaczenie

    /**
     *
     */
    private function loginLayout() {
        $this->layout()->setTemplate('layout/login');
    }

    /**
     *
     */
    private function registerLayout() {
        $this->layout()->setTemplate('layout/register');
    }

    /**
     *
     */
    public function indexAction()
    {
        $this->redirect()->toRoute('auth/login');
    }

    /**
     * @return ViewModel
     */
    public function loginAction()
    {
        $this->loginLayout();
        $this->_translator->addTranslationFile('gettext', ROOT_PATH . '/module/Application/language/' . LOCALE . '.mo');
        $facebook = (new OAuthServiceFactory())->create('fb');
        $google = (new OAuthServiceFactory())->create('google');
        $resp = [];

        $urlF = $facebook->generateAuthButton();
        $urlG = $google->generateAuthButton();

        $form = new LoginForm($this->_translator, ['name' => true, 'pass' => true],'Zaloguj', null);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $password = (new UserPassword())->create($data['password']);

            $adapter = $this->_as->getAdapter();
            $adapter->setIdentity($data['email']);
            $adapter->setCredential($password);
            $authResult = $adapter->authenticate();
            if ($authResult->getCode() == 1) {
                $authResult = $authResult->getIdentity();
                if ($authResult->isIsActive()) {
                    $this->setSession($authResult);
                } else {
                    $resp[] = $this->_translator->translate('Użytkownik ', 'default', LOCALE) . '<b>' . $data['email'] . '</b>' . $this->_translator->translate(' nie został aktywowany, proszę sprawdzić email', 'default', LOCALE);
                    $resp[] = $this->_translator->translate('Błąd', 'default', LOCALE);
                    $resp[] = 0;
                }
            } elseif ($authResult->getCode() == -1) {
                $resp[] = $this->_translator->translate('Użytkownik ', 'default', LOCALE) . '<b>' . $data['email'] . '</b>' . $this->_translator->translate(' nie istnieje', 'default', LOCALE);
                $resp[] = $this->_translator->translate('Ooops...', 'default', LOCALE);
                $resp[] = 2;
            } else {
                $resp[] = $this->_translator->translate('Złe hasło', 'default', LOCALE);
                $resp[] = $this->_translator->translate('Błąd', 'default', LOCALE);
                $resp[] = 1;
            }
        }

        return new ViewModel([
            'form' => $form,
            'urlF' => $urlF,
            'urlG' => $urlG,
            'resp' => json_encode($resp),
        ]);
    }

    /**
     * @return ViewModel
     */
    public function registerAction()
    {
        $this->registerLayout();
        $resp = [];
        $this->_translator->addTranslationFile('gettext', ROOT_PATH . '/module/Application/language/' . LOCALE . '.mo');
        $form = new RegisterForm($this->_translator, null);
        $filter = new RegisterFilter();
        $filter->setTranslator($this->_translator);
        $request = $this->getRequest();

        $form->setInputFilter($filter->getInputFilter(['name' => true, 'pass' => true]));

        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $user = $this->_em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
                if (!$user) {
                    $user = $this->_cef->create(User::class);
                    $this->registerMethod($user, $data);
                } elseif (($user->getGoogle() && !$user->getLocal()) || ($user->getFacebook() && !$user->getLocal())) {
                    $this->registerMethod($user, $data);
                } else {
                    $resp[] = $this->_translator->translate('Użytkownik ', 'default', LOCALE) . '<b>' . $data['email'] . '</b>' . $this->_translator->translate(' istnieje', 'default', LOCALE);
                    $resp[] = $this->_translator->translate('Błąd', 'default', LOCALE);
                    $resp[] = 2;
                }
            }
        }


        return new ViewModel([
            'form' => $form,
            'resp' => json_encode($resp),
        ]);
    }

    /**
     *
     */
    public function callbackAction()
    {
        $provider = $this->params()->fromRoute('provider');
        switch ($provider) {
            case 'fb': {
                $facebook = (new OAuthServiceFactory())->create('fb');
                $auth = $facebook->oAuthorize();
                $provider = 'facebook';
            }
                break;
            case 'google': {
                $google = (new OAuthServiceFactory())->create('google');
                $auth = $google->oAuthorize();
            }
                break;
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

//        if ($provider == 'facebook') {
//            echo '<img src="' . $auth['user']->getPictureUrl() . '" />';
//            die;
//        } elseif ($provider == 'google') {
//            echo '<img src="' . $auth['user']->getAvatar() . '" />';
//            die;
//        }

        $this->_em->persist($user);
        $this->_em->flush();

        $this->setSession($auth['user']);
    }

    /**
     * @param $authResult
     */
    private function setSession($authResult)
    {
        $user = $this->_em->getRepository(User::class)->findOneBy(['email' => $authResult->getEmail()]);
        $_SESSION['account_count'] = 0;
        $user->setDateLastLogin(new \DateTime());
        $this->_em->persist($user);
        $this->_em->flush();
        $session = new Container('User');
        $session->offsetSet('name', $authResult->getName());
        $session->offsetSet('role', $user->getRole()->getName());

        $this->redirect()->toRoute('home');
    }

    /**
     * @param $user
     * @param $data
     */
    private function registerMethod($user, $data) {
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
        setcookie('toast', $this->_translator->translate('Zarejestrowano, proszę sprawdzić maila', 'default', LOCALE), time() + 10);
        setcookie('title', $this->_translator->translate('Sukces', 'default', LOCALE), time() + 10);
        setcookie('state', 3, time() + 10);

        $this->redirect()->toRoute('application');
    }

    /**
     *
     */
    public function logoutAction()
    {
        $this->_as->clearIdentity();
        $session = new Container('User');
        $session->getManager()->getStorage()->clear('User');
        $_SESSION['account_count'] = 0;

        setcookie('toast', 'Wylogowano', time() + 10);
        setcookie('title', 'Info', time() + 10);
        setcookie('state', '2', time() + 10);
        $this->redirect()->toRoute('auth/login');
    }

    /**
     *
     */
    public function checkAction()
    {
        $id = $this->params()->fromQuery('id');
        $token = $this->params()->fromQuery('token');
        $user = $this->_em->getRepository(User::class)->findOneBy(['id' => $id, 'token' => $token]);
        $user->setIsActive(1);

        $this->_em->persist($user);
        $this->_em->flush();
        setcookie('toast', $this->_translator->translate('Aktywowano', 'default', LOCALE), time() + 10);
        setcookie('title', $this->_translator->translate('Sukces', 'default', LOCALE), time() + 10);
        setcookie('state', 2, time() + 10);

        $this->redirect()->toRoute('auth/login');
    }

    /**
     * @return ViewModel
     */
    public function resetPasswordAction()
    {
        $this->loginLayout();
        $resp = [];
        $form = new LoginForm($this->_translator, ['name' => true, 'pass' => false],'Wyślij email', null);
        $filter = new RegisterFilter();
        $filter->setTranslator($this->_translator);
        $form->setInputFilter($filter->getInputFilter(['name' => true, 'pass' => false]));
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $user = $this->_em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
                if ($user) {
                    $data = [
                        'email' => $user->getEmail(),
                        'token' => $user->getToken(),
                        'id' => $user->getId()
                    ];

                    $mailService = new MailService();
                    $mailService->resetPassword($data, $this->_translator);
                    setcookie('toast', 'Proszę sprawdzić maila', time() + 10);
                    setcookie('title', 'Sukces', time() + 10);
                    setcookie('state', '2', time() + 10);
                    $this->redirect()->toRoute('auth/login');
                } else {
                    $resp[] = $this->_translator->translate('Użytkownik ', 'default', LOCALE) . '<b>' . $data['email'] . '</b>' . $this->_translator->translate(' istnieje', 'default', LOCALE);
                    $resp[] = $this->_translator->translate('Błąd', 'default', LOCALE);
                    $resp[] = 0;
                }
            }
        }

        return new ViewModel([
            'form' => $form,
            'resp' => json_encode($resp),
        ]);
    }

    /**
     * @return ViewModel
     */
    public function resetPassCallAction()
    {
        $this->loginLayout();
        $id = $this->params()->fromQuery('id');
        $token = $this->params()->fromQuery('token');
        $user = $this->_em->getRepository(User::class)->findOneBy(['id' => $id, 'token' => $token]);
        $form = new LoginForm($this->_translator, ['name' => false, 'pass' => true],'Zresetuj', null);
        $filter = new RegisterFilter();
        $filter->setTranslator($this->_translator);
        $form->setInputFilter($filter->getInputFilter(['name' => false, 'pass' => true]));
        if ($user) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $data = $request->getPost();
                $form->setData($data);
                if ($form->isValid()) {
                    $password = (new UserPassword())->create($data['password']);
                    $token = (new TokenGenerator())->string(30);
                    $user->setPassword($password);
                    $user->setDateEdit(new \DateTime());
                    $user->setToken($token);

                    $this->_em->persist($user);
                    $this->_em->flush();

                    setcookie('toast', 'Teraz możesz się zalogować', time() + 10);
                    setcookie('title', 'Sukces', time() + 10);
                    setcookie('state', '3', time() + 10);
                    $this->redirect()->toRoute('auth/login');
                }
            }
        } else {
            setcookie('toast', 'Użytkownik nie istnieje!!!', time() + 10);
            setcookie('title', 'Błąd', time() + 10);
            setcookie('state', '0', time() + 10);
            $this->redirect()->toRoute('auth/login');
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }

}