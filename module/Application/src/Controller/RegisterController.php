<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;


use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;


class RegisterController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var EntityManager
     */
    private $entityManager;

    // Constructor method is used to inject dependencies to the controller.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // This is the default "index" action of the controller. It displays the
    // Posts page containing the recent blog posts.




    public function indexAction(){

       /** $username = $this->params()->fromPost("username");
        $password =  $this->params()->fromPost("password");
        $nom = $this->params()->fromPost("nom");
        $prenom = $this->params()->fromPost("prenom");
        $email =  $this->params()->fromPost("email");
        $datedenaissance = $this->params()->fromPost("date_de_naissance");

            $user = new User();

            $user->setUsername($username);
            $user->setPassword($password);
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setEmail($email);
            $user->setDateDeNaissance($datedenaissance);
            $user->setPoints(0);
            $user->setPartiesPerdues(0);
            $user->setPartiesGagnees(0);
            $user->setPourcentageReussite(0);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->getResponse()->setStatusCode(200);**/
            return new JsonModel(["message"=>"success"]);



    }



}
