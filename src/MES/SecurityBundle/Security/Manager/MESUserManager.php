<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MES\SecurityBundle\Security\Manager;

use Doctrine\ORM\EntityManager;
use MES\SecurityBundle\Entity\MesUserRoles;
use MES\SecurityBundle\Exception\UnsupportedClassException;
use MES\SecurityBundle\Security\MesUserInterface;
use MES\SecurityBundle\Security\Provider\MESUserProvider;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Description of MESUserManager
 *
 * @author Marcin Bonk <marvcin@gmail.com>
 */
class MESUserManager {

    /**
     *
     * @var string
     */
    private $class;

    /**
     *
     * @var MESUserProvider
     */
    private $userProvider;

    /**
     *
     * @var EntityManager
     */
    private $em;

    /**
     *
     * @var EncoderFactoryInterface
     */
    private $encoder;

    /**
     * 
     * @param MESUserProvider $userProvider
     * @param EntityManager $em
     * @param EncoderFactoryInterface $encoder
     */
    public function __construct(MESUserProvider $userProvider, EntityManager $em, EncoderFactoryInterface $encoder) {
        $this->userProvider = $userProvider;
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * 
     * @param type $username
     * @param type $email
     * @param type $password
     * @param type $name
     * @param type $surname
     * @return \MES\SecurityBundle\Security\Manager\MESUserManager
     */
    public function registerNewUser($username, $email, $password, $name, $surname) {
        /* @var $user MesUserInterface */
        $user = $this->createNewUser();

        $user
                ->setUsername($username)
                ->setEmail($email)
                ->setName($name)
                ->setSurname($surname)
                ->setSalt($this->getUserSalt($user))
                ->setPassword(
                        $this->encoder->getEncoder($user)->encodePassword($password, $this->getUserSalt($user))
        );

        $this->userProvider->updateUser($user);
        $this->userProvider->updateUser($user);
        return $this;
    }

    /**
     * 
     * @param MesUserInterface $user
     * @return type
     */
    public function getUserSalt(MesUserInterface $user) {
        return hash('sha256', base64_encode($user->getUsername()));
    }

    /**
     * 
     * @return MesUserInterface
     */
    public function createNewUser() {
        return new $this->class;
    }

    /**
     * 
     * @param MesUserRoles $role
     * @param MesUserInterface $user
     * @return MESUserManager
     */
    public function promoteUser(MesUserRoles $role, MesUserInterface $user) {
        $user->addMesUserRole($role);
        return $this;
    }

    /**
     * 
     * @param MesUserRoles $role
     * @param MesUserInterface $user
     * @return MESUserManager
     */
    public function demoteUser(MesUserRoles $role, MesUserInterface $user) {
        $user->removeMesUserRole($role);
        return $this;
    }

    /**
     * 
     * @param type $class
     * @return MESUserManager
     * @throws UnsupportedClassException
     */
    public function setClass($class) {
        if ($this->supportsClass($class) === false) {
            throw new UnsupportedClassException('Class ' . get_class($class) . ' is not supported.');
        }
        $this->class = $class;
        return $this;
    }

    /**
     * 
     * @param MesUserInterface $class
     * @return boolean
     */
    public function supportsClass($class) {
        return (( new $class) instanceof MesUserInterface);
    }

}
