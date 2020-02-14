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
use Application\Entity\GameHistory;
use Application\Entity\User;
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
            $players = $this->entityManager->getRepository(User::class)->findAll();
            $joueurs=[];
            foreach ($players as $p ){
                $joueur=array("id_u"=>$p->getId(),
                    "username"=>$p->getUsername(),
                    "password"=>$p->getPassword(),
                    "nom"=>$p->getNom(),
                    "prenom"=>$p->getPrenom(),
                    "email"=>$p->getEmail(),
                    "date_de_naissance"=>$p->getDateDeNaissance(),
                    "image"=>$p->getImage(),
                    "points"=>$p->getPoints(),
                    "parties_gagnees"=>$p->getPartiesGagnees(),
                    "parties_perdues"=>$p->getPartiesPerdues(),
                    "etat"=>$p->getEtat(),
                    "pourcentage_reussite"=>$p->getPourcentageReussite()
                );
                array_push($joueurs, $joueur);
            }

            $gamesF = $this->entityManager->getRepository(GameHistory::class)->findAll();
            $games=[];
            foreach ($gamesF as $p ){
                $game=array("id_j"=>$p->getIdJ(),
                    "id_u"=>$p->getIdU(),
                    "id_adversaire"=>$p->getIdAdversaire(),
                    "date_et_heure"=>$p->getDateEtHeure(),
                    "nombre_de_tours"=>$p->getNombreDeTours(),
                    "gagner"=>$p->getGagner()
                );
                array_push($games, $game);
            }

            $gameso = $this->entityManager->getRepository(Game::class)->findAll();
            $gamesOnline=[];
            foreach ($gameso as $p ){
                $game=array("id_u1"=>$p->getIdU1(),
                    "id_u2"=>$p->getIdU2(),
                    "room"=>$p->getRoom(),
                    "nombre_u1"=>$p->getNombreU1(),
                    "nombre_u2"=>$p->getNombreU2(),
                    "date_et_heure"=>$p->getDateEtHeure(),
                    "nombre_de_tours"=>$p->getNombreDeTours()
                );
                array_push($gamesOnline, $game);
            }

            $tmp = json_decode(json_encode($gamesOnline));
            $nombreparties=0;
            foreach ($tmp as $game){
                $nombreparties = $nombreparties + $game->nombre_de_tours;
            }



            return new ViewModel([
                "joueurs"=>$joueurs,
                "games_history"=>$games,
                "games_online"=>$gamesOnline,
                "nombre_de_tours"=>$nombreparties,
                "lastlog"=>$admin->getLastLog()
            ]);
            //return new JsonModel(["Hiiiii you are logged"]);
        } else {
            $this->redirect()->toRoute('admin');
        }
    }


    public function logoutAction(){
        $this->authenticationService->getStorage()->clear();
        $this->redirect()->toRoute('admin');
    }


    public function indexAction()
    {
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

                $admin = $this->entityManager->getRepository(Admin::class)->find( $identity->getId());
                $admin->setLastLog(date("Y-m-d H:i:s"));
                $this->entityManager->flush();
                return $this->redirect()->toRoute('admin',array(
                    'controller' => 'admin',
                    'action' =>  'home',
                ));
                //$identity = $authResult->getIdentity();
                //return new JsonModel(["ok"=>$identity->getPassword()]);
            }

            else{
                $view = new ViewModel(['error' => 'Your authentication credentials are not valid']);
                return $view;
            }

        }
        else {

        $admin = $this->authenticationService->getIdentity();
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

    }}

    public function authAction(){



    }




    public static function verifyCredential(Admin $admin, $inputPassword)
    {
        return password_verify($inputPassword, $admin->getPassword());
    }



}
