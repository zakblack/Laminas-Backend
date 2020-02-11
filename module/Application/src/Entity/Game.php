<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single post in a blog.
 * @ORM\Entity
 * @ORM\Table(name="jouer")
 */
class Game
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id_u1")
     */
    protected $id_u1;


    /**
     * @ORM\Id
     * @ORM\Column(name="id_u2")
     */
    protected $id_u2;

    /**
     * @ORM\Column(name="room")
     */
    protected $room;

    /**
     * @ORM\Column(name="nombre_u1")
     */
    protected $nombre_u1;

    /**
     * @ORM\Column(name="nombre_u2")
     */
    protected $nombre_u2;

    /**
     * @ORM\Column(name="date_et_heure")
     */
    protected $date_et_heure;

    /**
     * @ORM\Column(name="nombre_de_tours")
     */
    protected $nombre_de_tours;

    /**
     * @return mixed
     */
    public function getIdU1()
    {
        return $this->id_u1;
    }

    /**
     * @param mixed $id_u1
     */
    public function setIdU1($id_u1): void
    {
        $this->id_u1 = $id_u1;
    }

    /**
     * @return mixed
     */
    public function getIdU2()
    {
        return $this->id_u2;
    }

    /**
     * @param mixed $id_u2
     */
    public function setIdU2($id_u2): void
    {
        $this->id_u2 = $id_u2;
    }

    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom($room): void
    {
        $this->room = $room;
    }

    /**
     * @return mixed
     */
    public function getNombreU1()
    {
        return $this->nombre_u1;
    }

    /**
     * @param mixed $nombre_u1
     */
    public function setNombreU1($nombre_u1): void
    {
        $this->nombre_u1 = $nombre_u1;
    }

    /**
     * @return mixed
     */
    public function getNombreU2()
    {
        return $this->nombre_u2;
    }

    /**
     * @param mixed $nombre_u2
     */
    public function setNombreU2($nombre_u2): void
    {
        $this->nombre_u2 = $nombre_u2;
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





}