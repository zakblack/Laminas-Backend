<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single post in a blog.
 * @ORM\Entity
 * @ORM\Table(name="historique_con")
 */
class ConnectionLog
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_c")
     */
    protected $id_c;


    /**
     * @ORM\Column(name="id_u")
     */
    protected $id_u;

    /**
     * @ORM\Column(name="connexion")
     */
    protected $connexion;

    /**
     * @ORM\Column(name="deconnexion")
     */
    protected $deconnexion;

    /**
     * @return mixed
     */
    public function getIdC()
    {
        return $this->id_c;
    }

    /**
     * @param mixed $id_c
     */
    public function setIdC($id_c): void
    {
        $this->id_c = $id_c;
    }

    /**
     * @return mixed
     */
    public function getIdU()
    {
        return $this->id_u;
    }

    /**
     * @param mixed $id_u
     */
    public function setIdU($id_u): void
    {
        $this->id_u = $id_u;
    }

    /**
     * @return mixed
     */
    public function getConnexion()
    {
        return $this->connexion;
    }

    /**
     * @param mixed $connexion
     */
    public function setConnexion($connexion): void
    {
        $this->connexion = $connexion;
    }

    /**
     * @return mixed
     */
    public function getDeconnexion()
    {
        return $this->deconnexion;
    }

    /**
     * @param mixed $deconnexion
     */
    public function setDeconnexion($deconnexion): void
    {
        $this->deconnexion = $deconnexion;
    }



    }