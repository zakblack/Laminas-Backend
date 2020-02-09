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
use Laminas\Http;



class UsersController extends AbstractActionController
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


        if ($this->verify($this->getRequest())){
            if($this->getRequest()->isGet()){


            $posts = $this->entityManager->getRepository(User::class)->findAll();
            $joueurs=[];
            foreach ($posts as $p ){
                $joueur=array("id"=>$p->getId(),
                    "username"=>$p->getUsername()
                );
                array_push($joueurs, $joueur);
            }

            return new JsonModel($joueurs);
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
        // Get recent posts

        /**return new JsonModel([
        'status' => 'SUCCESS',
        'message'=>'Here is your data',
        'data' => [
        'full_name' => 'John Doe',
        'address' => '51 Middle st.'
        ]
        ]);**/
    }

    public function vAction(){
        return new JsonModel([$this->verify($this->getRequest())]);
    }

    public function profileAction()
    {
        if ($this->verify($this->getRequest())){
            if($this->getRequest()->isGet()){

                $id_player=$this->params()->fromQuery("id");
                if ($id_player == $this->getID($this->getRequest())) {
                    $player = $this->entityManager->getRepository(User::class)->find($id_player);
                    $joueur=array("id"=>$player->getId(),
                        "username"=>$player->getUsername(),
                        "email"=>$player->getEmail(),
                        "nom"=>$player->getNom(),
                        "prenom"=>$player->getPrenom(),
                        "date_de_naissance"=>$player->getDateDeNaissance(),
                        "image"=>$player->getImage(),
                        "points"=>$player->getPoints(),
                        "parties_gagnees"=>$player->getPartiesGagnees(),
                        "parties_perdues"=>$player->getPartiesPerdues(),
                        "etat"=>$player->getEtat(),
                        "pourcentage_reussite"=>$player->getPourcentageReussite()

                    );
                    $this->getResponse()->setStatusCode(200);
                    return new JsonModel($joueur);
                }
                else {
                    $this->getResponse()->setStatusCode(401);
                    return new JsonModel(["message"=>"Unauthorized"]);


            }}
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

    public function editAction(){
        if ($this->verify($this->getRequest())){
            if($this->getRequest()->isPut()){

                $id_player=$this->params()->fromQuery("id");
                if ($id_player == $this->getID($this->getRequest())) {
                    $user = $this->entityManager->getRepository(User::class)->find($id_player);
                    $user->setUsername($this->params()->fromQuery("username"));
                   // $user->setPassword($this->params()->fromQuery("password"));
                    $user->setNom($this->params()->fromQuery("nom"));
                    $user->setPrenom($this->params()->fromQuery("prenom"));
                    $user->setEmail($this->params()->fromQuery("email"));
                    $user->setDateDeNaissance($this->params()->fromQuery("date_de_naissance"));
                    $user->setPoints($this->params()->fromQuery("image"));
                    $user->setPartiesPerdues($this->params()->fromQuery("parties_perdues"));
                    $user->setPartiesGagnees($this->params()->fromQuery("parties_gagnees"));
                    $user->setPourcentageReussite($this->params()->fromQuery("pourcentage_reussite"));
                    $this->entityManager->flush();
                    return new JsonModel([$user->getUsername()]);
                }
                else {
                    return new JsonModel(["message"=>"Unauthorized"]);


                }}
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
        if ($this->verify($this->getRequest())){
            if($this->getRequest()->isDelete()){

                $id_player=$this->params()->fromQuery("id");
                if ($id_player == $this->getID($this->getRequest())) {
                    $user = $this->entityManager->getRepository(User::class)->find($id_player);
                    if (isset($user)){
                        $this->entityManager->remove($user);
                        $this->entityManager->flush();
                        return new JsonModel([$user->getUsername()]);
                    }
                    else {
                        $this->getResponse()->setStatusCode(401);
                        return new JsonModel(["User not found"]);
                    }

                }
                else {
                    $this->getResponse()->setStatusCode(401);
                    return new JsonModel(["message"=>"Unauthorized"]);


                }}
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
        $var=(int) $var->payload->id;
        return $var;
    }



    private function verify($request){
        $msg = $request->getHeaders()->get('authorization')->getFieldValue();
        $key = "123456";
        $msg = str_replace("Bearer ", "", $msg);
        return JwtController::verifyJwt($msg);
    }

}
