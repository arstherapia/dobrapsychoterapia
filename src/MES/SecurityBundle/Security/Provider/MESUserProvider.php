<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MES\SecurityBundle\Security\Provider;

use Doctrine\ORM\EntityManager;
use MES\SecurityBundle\Security\MesUserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 *
 * @author Marcin Bonk <marvcin@gmail.com>
 */
class MESUserProvider implements UserProviderInterface {

    private $em;
    private $class;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * 
     * @param string $class
     * @return MESUserProvider
     */
    public function setClass($class) {
        $this->class = $class;
        return $this;
    }

    /**
     * 
     * @param string $username
     * @return MesUserInterface
     */
    public function loadUserByUsername($username) {
        return $this->findUserBy(['username' => $username]);
    }

    /**
     * 
     * @param array $criteria
     * @return MesUserInterface
     */
    public function findUserBy(array $criteria) {
        $user = $this->em->getRepository($this->class)->findOneBy($criteria);
        if($user instanceof UserInterface === false){
            throw new UsernameNotFoundException();
        }
        return $user;
    }

    /**
     * 
     * @param UserInterface $user
     * @return MesUserInterface
     */
    public function refreshUser(UserInterface $user) {
        return $this->findUserBy(['username' => $user->getUsername()]);
    }

    /**
     * 
     * @param MesUserInterface $user
     * @return MESUserProvider
     */
    public function updateUser(MesUserInterface $user) {
        $this->em->persist($user);
        $this->em->flush();
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
