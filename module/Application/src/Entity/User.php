<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single post in a blog.
   @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_u")
     */
    protected $id;

    /**
     * @ORM\Column(name="username")
     */
    protected $username;

    /**
     * @ORM\Column(name="email")
     */
    protected $email;

    /**
     * @ORM\Column(name="password")
     */
    protected $password;

    /**
     * @ORM\Column(name="prenom")
     */
    protected $prenom;

    /**
     * @ORM\Column(name="nom")
     */
    protected $nom;

    /**
     * @ORM\Column(name="date_de_naissance")
     */
    protected $date_de_naissance;

    /**
     * @ORM\Column(name="image")
     */
    protected $image;

    /**
     * @ORM\Column(name="points")
     */
    protected $points;

    /**
     * @ORM\Column(name="parties_gagnees")
     */
    protected $parties_gagnees;


    /**
     * @ORM\Column(name="parties_perdues")
     */
    protected $parties_perdues;


    /**
     * @ORM\Column(name="etat")
     */
    protected $etat;


    /**
     * @ORM\Column(name="pourcentage_reussite")
     */
    protected $pourcentage_reussite;


    public function getId()
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function setUsername($username): void
    {
        $this->username = $username;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email): void
    {
        $this->email = $email;
    }


    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword($password): void
    {
        $this->password = $password;
    }


    public function getPrenom()
    {
        return $this->prenom;
    }


    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }


    public function getNom()
    {
        return $this->nom;
    }


    public function setNom($nom): void
    {
        $this->nom = $nom;
    }


    public function getDateDeNaissance()
    {
        return $this->date_de_naissance;
    }


    public function setDateDeNaissance($date_de_naissance): void
    {
        $this->date_de_naissance = $date_de_naissance;
    }


    public function getImage()
    {
        return $this->image;
    }


    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getPoints()
    {
        return $this->points;
    }


    public function setPoints($points): void
    {
        $this->points = $points;
    }


    public function getPartiesGagnees()
    {
        return $this->parties_gagnees;
    }


    public function setPartiesGagnees($parties_gagnees): void
    {
        $this->parties_gagnees = $parties_gagnees;
    }


    public function getPartiesPerdues()
    {
        return $this->parties_perdues;
    }


    public function setPartiesPerdues($parties_perdues): void
    {
        $this->parties_perdues = $parties_perdues;
    }


    public function getEtat()
    {
        return $this->etat;
    }


    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }


    public function getPourcentageReussite()
    {
        return $this->pourcentage_reussite;
    }


    public function setPourcentageReussite($pourcentage_reussite): void
    {
        $this->pourcentage_reussite = $pourcentage_reussite;
    }







}