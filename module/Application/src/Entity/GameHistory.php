<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single post in a blog.
 * @ORM\Entity
 * @ORM\Table(name="historique_jeu")
 */
class GameHistory
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_j")
     */
    protected $id_j;


    /**
     * @ORM\Column(name="id_u")
     */
    protected $id_u;

    /**
     * @ORM\Column(name="id_adversaire")
     */
    protected $id_adversaire;

    /**
     * @ORM\Column(name="date_et_heure")
     */
    protected $date_et_heure;

    /**
     * @ORM\Column(name="nombre_de_tours")
     */
    protected $nombre_de_tours;

    /**
     * @ORM\Column(name="gagner")
     */
    protected $gagner;


    /**
     * @return mixed
     */
    public function getIdJ()
    {
        return $this->id_j;
    }

    /**
     * @param mixed $id_j
     */
    public function setIdJ($id_j): void
    {
        $this->id_j = $id_j;
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
    public function getIdAdversaire()
    {
        return $this->id_adversaire;
    }

    /**
     * @param mixed $id_adversaire
     */
    public function setIdAdversaire($id_adversaire): void
    {
        $this->id_adversaire = $id_adversaire;
    }

    /**
     * @return mixed
     */
    public function getDateEtHeure()
    {
        return $this->date_et_heure;
    }

    /**
     * @param mixed $date_et_heure
     */
    public function setDateEtHeure($date_et_heure): void
    {
        $this->date_et_heure = $date_et_heure;
    }

    /**
     * @return mixed
     */
    public function getNombreDeTours()
    {
        return $this->nombre_de_tours;
    }

    /**
     * @param mixed $nombre_de_tours
     */
    public function setNombreDeTours($nombre_de_tours): void
    {
        $this->nombre_de_tours = $nombre_de_tours;
    }

    /**
     * @return mixed
     */
    public function getGagner()
    {
        return $this->gagner;
    }

    /**
     * @param mixed $gagner
     */
    public function setGagner($gagner): void
    {
        $this->gagner = $gagner;
    }








}