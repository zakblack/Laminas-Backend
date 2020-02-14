<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;


use Application\Entity\Admin;
use Application\Entity\Game;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\SessionManager;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Laminas\Http;


class AdminController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Auth manager.
     * @var Application\Service
     */
    private $authManager;

    /**
     * Auth service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    // Constructor method is used to inject dependencies to the controller.
    public function __construct($entityManager,$sessionManager)
    {
        $this->entityManager = $entityManager;
        $this->sessionManager = $sessionManager;
    }

    // This is the default "index" action of the controller. It displays the
    // Posts page containing the recent blog posts.
    public function indexAction()
    {


        return new ViewModel();
        //return new JsonModel(["massage"=>"Administration"]);

    }

    public function authAction(){
        if($this->getRequest()->isPost()){

            $username = $this->params()->fromPost("username");
            $password =  $this->params()->fromPost("password");
            $admin = $this->entityManager->getRepository(Admin::class)->findOneBy(["username"=>$username,"password"=>$password]);


        }
        else {

            $this->redirect()->toRoute('admin');
        }
    }

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();

        // The following line instantiates the SessionManager and automatically
        // makes the SessionManager the 'default' one.
        $this->sessionManager = $serviceManager->get(SessionManager::class);
    }


    private function getID($request){
        $msg = $request->getHeaders()->get('authorization')->getFieldValue();
        $msg = str_replace("Bearer ", "", $msg);
        $var=JwtController::deconstructJwt($msg);
        $var=json_encode($var);
        $var=json_decode($var);
        $var=(int) $var->payload->id_u;
        return $var;
    }



    private function verify($request){

        $msg = $request->getHeaders()->get('authorization')->getFieldValue();

        $msg = str_replace("Bearer ", "", $msg);
        return JwtController::verifyJwt($msg);
    }



}
