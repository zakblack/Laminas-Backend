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

    }

