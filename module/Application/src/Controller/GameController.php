<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;


use Application\Entity\Game;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;


class GameController extends AbstractActionController
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



        return new JsonModel(["massage"=>"Forbidden"]);

    }

    public function addAction()
    {
        if ($this->verify($this->getRequest())){
            if($this->getRequest()->isPost()){
                $idu1=$this->params()->fromPost("id_u1");
                $idu2=$this->params()->fromPost("id_u2");
                $room=$this->params()->fromPost("room");
                $nombreu1=$this->params()->fromPost("nombre_u1");
                $nombreu2=$this->params()->fromPost("nombre_u2");
                $dateetheure=$this->params()->fromPost("date_et_heure");
                $game = new Game();
                $game->setIdU1($idu1);
                $game->setIdU2($idu2);
                $game->setRoom($room);
                $game->setNombreU1($nombreu1);
                $game->setNombreU2($nombreu2);
                $game->setDateEtHeure($dateetheure);
                $game->setNombreDeTours(0);
                $this->entityManager->persist($game);
                $this->entityManager->flush();
                $this->getResponse()->setStatusCode(200);
                return new JsonModel(["ok"]);
                }

            else {
                $this->getResponse()->setStatusCode(401);
                return new JsonModel(["message"=>"Unauthorized"]);
            }

        }
        else {

            $this->getResponse()->setStatusCode(403);
            return new JsonModel(["message"=>"Forbidden"]);

        }
    }

    public function getAction()
    {
        if ($this->verify($this->getRequest())){
            if($this->getRequest()->isGet()){
                $room=$this->params()->fromQuery("room");
                $game = $this->entityManager->getRepository(Game::class)->findOneBy(["room"=>$room]);
                if (isset($game)){
                    $jouer=array("id_u1"=>$game->getIdU1(),
                        "id_u2"=>$game->getIdU2(),
                        "room"=>$game->getRoom(),
                        "nombre_u1"=>$game->getNombreU1(),
                        "nombre_u2"=>$game->getNombreU2(),
                        "date_et_heure"=>$game->getDateEtHeure(),
                        "nombre_de_tours"=>$game->getNombreDeTours()
                    );

                    $this->getResponse()->setStatusCode(200);
                    return new JsonModel($jouer);
                }
                else {
                    $this->getResponse()->setStatusCode(401);
                    return new JsonModel(["message"=>"Room not found"]);
                }

            }

            else {
                $this->getResponse()->setStatusCode(401);
                return new JsonModel(["message"=>"Unauthorized"]);
            }

        }
        else {

            $this->getResponse()->setStatusCode(403);
            return new JsonModel(["message"=>"Forbidden"]);

        }
    }

    public function addTourAction()
    {
        if ($this->verify($this->getRequest())){
            if($this->getRequest()->isPut()){
                $room=$this->params()->fromQuery("room");
                $game = $this->entityManager->getRepository(Game::class)->findOneBy(["room"=>$room]);
                if (isset($game)){
                    $nbr=$game->getNombreDeTours();
                    $game->setNombreDeTours($nbr+1);
                    $this->entityManager->flush();
                    $this->getResponse()->setStatusCode(200);
                    return new JsonModel(["ok"]);
                }
                else {
                    $this->getResponse()->setStatusCode(401);
                    return new JsonModel(["message"=>"Room not found"]);
                }

            }

            else {
                $this->getResponse()->setStatusCode(401);
                return new JsonModel(["message"=>"Unauthorized"]);
            }

        }
        else {

            $this->getResponse()->setStatusCode(403);
            return new JsonModel(["message"=>"Forbidden"]);

        }
    }

    public function endAction(){
        if ($this->verify($this->getRequest())){
            if($this->getRequest()->isDelete()){

                $roomid=$this->params()->fromQuery("room");

                    $room = $this->entityManager->getRepository(Game::class)->find($roomid);
                    if (isset($room)){
                        $this->entityManager->remove($room);
                        $this->entityManager->flush();
                        return new JsonModel([$room->getIdRoom()]);
                    }
                    else {
                        $this->getResponse()->setStatusCode(401);
                        return new JsonModel(["Game not found"]);
                    }


                }
            else {
                $this->getResponse()->setStatusCode(401);
                return new JsonModel(["message"=>"Unauthorized"]);
            }

        }
        else {

            $this->getResponse()->setStatusCode(403);
            return new JsonModel(["message"=>"Forbidden"]);

        }
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
