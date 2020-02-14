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



    private $authenticationService;

    // Constructor method is used to inject dependencies to the controller.
    public function __construct($entityManager,$authenticationService)
    {
        $this->entityManager = $entityManager;
        $this->authenticationService = $authenticationService;
    }


    public function homeAction(){
        $admin = $this->authenticationService->getIdentity();
        if ($admin) {
            return new JsonModel(["Hiiiii you are logged"]);
        } else {
            $this->redirect()->toRoute('admin');
        }
    }


    public function logoutAction(){
        $this->authenticationService->getStorage()->clear();
        $this->redirect()->toRoute('admin');
    }


    public function indexAction()
    {    $admin = $this->authenticationService->getIdentity();
        if ($admin) {
            return $this->redirect()->toRoute('admin',array(
                'controller' => 'admin',
                'action' =>  'home',
            ));
        }
        else {
            $password="123456789";
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return new ViewModel(
            ["data"=>$hashed_password]
        );}

       // return new JsonModel(["massage"=>"$hashed_password"]);

    }

    public function authAction(){
        if($this->getRequest()->isPost()){


            $data = $this->getRequest()->getPost();

            $adapter = $this->authenticationService->getAdapter();
            $adapter->setIdentity($data['username']);
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
            $adapter->setCredential($data['password']);
            $authResult = $this->authenticationService->authenticate();

            if ($authResult->isValid()) {

                $identity =$authResult->getIdentity();
                $this->authenticationService->getStorage()->write($identity);
                return $this->redirect()->toRoute('admin',array(
                    'controller' => 'admin',
                    'action' =>  'home',
                ));
                //$identity = $authResult->getIdentity();
                //return new JsonModel(["ok"=>$identity->getPassword()]);
            }

            return new JsonModel(["error"]);
            //return new ViewModel(['error' => 'Your authentication credentials are not valid',]);

        }
        else {

            $this->redirect()->toRoute('admin');
        }
    }




    public static function verifyCredential(Admin $admin, $inputPassword)
    {
        return password_verify($inputPassword, $admin->getPassword());
    }



}
