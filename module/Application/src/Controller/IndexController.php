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


class IndexController extends AbstractActionController
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
    public function indexAction()
    {
        // Get recent posts
        $posts = $this->entityManager->getRepository(User::class)->findAll();
        $joueurs=[];
        foreach ($posts as $p ){
            $joueur=array("id"=>$p->getId(),"username"=>$p->getUsername());
            array_push($joueurs, $joueur);
        }

        return new JsonModel($joueurs);
        /**return new JsonModel([
            'status' => 'SUCCESS',
            'message'=>'Here is your data',
            'data' => [
                'full_name' => 'John Doe',
                'address' => '51 Middle st.'
            ]
        ]);**/
    }

    public function loginAction()
    {
        $getVar = $this->params()->fromPost('abc');
        $a=array("abc"=> $getVar);
        return new JsonModel($a);
    }

}
