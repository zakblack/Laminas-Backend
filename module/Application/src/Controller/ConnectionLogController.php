<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;



use Application\Entity\GameHistory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;


class ConnectionLogController extends AbstractActionController
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





    }

    public function getAction(){
        $id_u=$this->params()->fromQuery("id_u");
        $room1 = $this->entityManager->getRepository(GameHistory::class)->findBy(["id_u"=>$id_u]);
        $room2 = $this->entityManager->getRepository(GameHistory::class)->findBy(["id_adversaire"=>$id_u]);
        //if(is_array($room1)){

            $parties1=[];
            foreach ($room1 as $r ){
                $partie=array("id_j"=>$r->getIdJ(),
                    "id_u"=>$r->getIdU(),
                    "id_adversaire"=>$r->getIdAdversaire(),
                    "date_et_heure"=>$r->getDateEtHeure(),
                    "nombre_de_tours"=>$r->getNombreDeTours(),
                    "temps_passe"=>$r->getTempsPasse(),
                    "gagner"=>$r->getGagner()
                );
                array_push($parties1, $partie);
           }// }

        $parties2=[];
        foreach ($room2 as $r ){
            $partie=array("id_j"=>$r->getIdJ(),
                "id_u"=>$r->getIdU(),
                "id_adversaire"=>$r->getIdAdversaire(),
                "date_et_heure"=>$r->getDateEtHeure(),
                "nombre_de_tours"=>$r->getNombreDeTours(),
                "temps_passe"=>$r->getTempsPasse(),
                "gagner"=>$r->getGagner()
            );
            array_push($parties2, $partie);}





        return new JsonModel(["id_u"=>json_decode(json_encode($parties1)),"id_adversaire"=>$parties2]);
        //return new JsonModel($parties1);

    }
    public function addAction(){

        if($this->getRequest()->isPost()){
        if ($this->verify($this->getRequest())){


                $gameh=new GameHistory();
                $gameh->setIdU($this->params()->fromPost("id_u"));
                $gameh->setIdAdversaire($this->params()->fromPost("id_adversaire"));
                $gameh->setDateEtHeure($this->params()->fromPost("date_et_heure"));
                $gameh->setNombreDeTours($this->params()->fromPost("nombre_de_tours"));
                $gameh->setTempsPasse($this->params()->fromPost("temps_passe"));
                $gameh->setGagner($this->params()->fromPost("gagner"));
                $this->entityManager->persist($gameh);
                $this->entityManager->flush();
                $this->getResponse()->setStatusCode(200);
                return new JsonModel(["message"=>"Success"]);

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

    public function deleteAction(){

            if($this->getRequest()->isDelete()){
                if ($this->verify($this->getRequest())){
                    $id_j=$this->params()->fromQuery("id_j");

                $room = $this->entityManager->getRepository(GameHistory::class)->find($id_j);
                if (isset($room)){

                        $this->entityManager->remove($room);

                        $this->entityManager->flush();

                    $this->getResponse()->setStatusCode(200);
                    return new JsonModel(["message"=>"Success"]);
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




    public function notFoundAction()
    {
        $this->getResponse()->setStatusCode(404);
        return new JsonModel();
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
        $requete = $request->getHeaders()->get('authorization');

        if ($requete == null){

            return false;
        }
        else {
            $msg = $request->getHeaders()->get('authorization')->getFieldValue();
            $msg = str_replace("Bearer ", "", $msg);
            return JwtController::verifyJwt($msg);
        }

    }



}
