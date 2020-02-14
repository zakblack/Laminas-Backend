<?php
namespace Application\Service;

use Application\Entity\Admin;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\Result;
use Laminas\Crypt\Password\Bcrypt;
use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Adapter used for authenticating user. It takes login and password on input
 * and checks the database if there is a user with such login (email) and password.
 * If such user exists, the service returns his identity (email). The identity
 * is saved to session and can be retrieved later with Identity view helper provided
 * by ZF3.
 */
class AuthAdapter implements AdapterInterface
{
    /**
     * Admin username.
     * @var string
     */
    private $username;

    /**
     * Password
     * @var string
     */
    private $password;

    /**
     * Entity manager.
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Sets user email.
     */
    public function setUsername($email)
    {
        $this->username = $email;
    }

    /**
     * Sets password.
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }

    /**
     * Performs an authentication attempt.
     */
    public function authenticate()
    {
        // Check the database if there is a user with such email.
        $user = $this->entityManager->getRepository(Admin::class)
            ->findOneByEmail($this->username);

        // If there is no such user, return 'Identity Not Found' status.
        if ($user==null) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Invalid credentials.']);
        }

        // If the user with such email exists, we need to check if it is active or retired.
        // Do not allow retired users to log in.
        if ($user->getStatus()==User::STATUS_RETIRED) {
            return new Result(
                Result::FAILURE,
                null,
                ['User is retired.']);
        }

        // Now we need to calculate hash based on user-entered password and compare
        // it with the password hash stored in database.
        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();

        if ($bcrypt->verify($this->password, $passwordHash)) {
            // Great! The password hash matches. Return user identity (email) to be
            // saved in session for later use.
            return new Result(
                Result::SUCCESS,
                $this->username,
                ['Authenticated successfully.']);
        }

        // If password check didn't pass return 'Invalid Credential' failure status.
        return new Result(
            Result::FAILURE_CREDENTIAL_INVALID,
            null,
            ['Invalid credentials.']);
    }
}