<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single post in a blog.
   @ORM\Entity
 * @ORM\Table(name="admin")
 */
class Admin
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="username")
     */
    protected $username;


    /**
     * @ORM\Column(name="password")
     */
    protected $password;


    /**
     * @ORM\Column(name="last_log")
     */
    protected $last_log;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getLastLog()
    {
        return $this->last_log;
    }

    /**
     * @param mixed $last_log
     */
    public function setLastLog($last_log): void
    {
        $this->last_log = $last_log;
    }

    }

