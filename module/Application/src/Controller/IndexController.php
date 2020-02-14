<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;


use Application\Entity\ConnectionLog;
use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use Firebase\JWT\JWT;
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


        return new JsonModel(["Welcome"=>"Laminas backend deployed by Zakaria GHARIB"]);
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
        $username = $this->params()->fromPost("username");
        $password =  $this->params()->fromPost("password");
        $player = $this->entityManager->getRepository(User::class)->findOneBy(["username"=>$username,"password"=>$password]);
        if (isset($player)) {
            /**$key = "123456";
            $payload = array(
                "id" => $player->getId(),
                "time" => time(),
                "username" => $player->getUsername()
            );
            $token = JWT::encode($payload, $key);**/
            $player->setEtat(1);
            $connexion = new ConnectionLog();
            $connexion->setIdU($player->getId());
            $connexion->setConnexion(date("Y-m-d H:i:s"));
            $this->entityManager->persist($connexion);
            $this->entityManager->flush();
            $token = JwtController::generateJwt($player);
            $this->getResponse()->setStatusCode(200);
            return new JsonModel(["message"=>"success","token"=>$token]);

        }
        else {
            $this->getResponse()->setStatusCode(403);
            return new JsonModel(["message"=>"Forbidden"]);
        }

    }


    public function logoutAction()
    {
        if ($this->verify($this->getRequest())){


        $id_u =  $this->params()->fromQuery("id_u");
            if ($id_u == $this->getID($this->getRequest())){
        $connexion = $this->entityManager->getRepository(ConnectionLog::class)->findOneBy(array('id_u'=>$id_u),
            array('connexion' => 'DESC'));
        if (isset($connexion)) {

            $player = $this->entityManager->getRepository(User::class)->find($id_u);
            $player->setEtat(0);
            $connexion->setDeconnexion(date("Y-m-d H:i:s"));
            $this->entityManager->flush();
            $this->getResponse()->setStatusCode(200);
            return new JsonModel(["message"=>"success"]);

        }
        else {
            $this->getResponse()->setStatusCode(403);
            return new JsonModel(["message"=>"Forbidden"]);
        }}
            else{
                $this->getResponse()->setStatusCode(403);
                return new JsonModel(["message"=>"Forbidden"]);
            }

        }
        else {

            $this->getResponse()->setStatusCode(403);
            return new JsonModel(["message"=>"Forbidden"]);

        }

    }
/**
    public function registerAction(){

        $username = $this->params()->fromPost("username");
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

            $this->getResponse()->setStatusCode(200);
            return new JsonModel(["message"=>"success","id"=>$user->getId()]);



    }**/

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
