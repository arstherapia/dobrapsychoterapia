<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MES\SecurityBundle\Security;

/**
 *
 * @author Marcin Bonk <marvcin@gmail.com>
 */
interface MesUserInterface extends \Symfony\Component\Security\Core\User\UserInterface {

    public function setEmail($email);

    public function getEmail();

    /**
     * Set successLoginCount
     *
     * @param integer $successLoginCount
     * @return MesUser
     */
    public function setSuccessLoginCount($successLoginCount);

    /**
     * Get successLoginCount
     *
     * @return integer 
     */
    public function getSuccessLoginCount();

    /**
     * Set failedLoginCount
     *
     * @param integer $failedLoginCount
     * @return MesUser
     */
    public function setFailedLoginCount($failedLoginCount);

    /**
     * Get failedLoginCount
     *
     * @return integer 
     */
    public function getFailedLoginCount();

    /**
     * Set salt
     *
     * @param string $salt
     * @return MesUser
     */
    public function setSalt($salt);

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt();

    /**
     * Set password
     *
     * @param string $password
     * @return MesUser
     */
    public function setPassword($password);

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword();

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return MesUser
     */
    public function setDateCreated($dateCreated);

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated();

    /**
     * Set lastSuccess
     *
     * @param \DateTime $lastSuccess
     * @return MesUser
     */
    public function setLastSuccess($lastSuccess);

    /**
     * Get lastSuccess
     *
     * @return \DateTime 
     */
    public function getLastSuccess();

    /**
     * Set lastFail
     *
     * @param \DateTime $lastFail
     * @return MesUser
     */
    public function setLastFail($lastFail);

    /**
     * Get lastFail
     *
     * @return \DateTime 
     */
    public function getLastFail();

    /**
     * Set name
     *
     * @param string $name
     * @return MesUser
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string 
     */
    public function getName();

    /**
     * Set surname
     *
     * @param string $surname
     * @return MesUser
     */
    public function setSurname($surname);

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname();

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return MesUser
     */
    public function setIsActive($isActive);

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive();

    /**
     * Add mesUserGroups
     *
     * @param \MES\UserBundle\Entity\MesUserGroups $mesUserGroups
     * @return MesUser
     */
    public function addMesUserGroup(\MES\UserBundle\Entity\MesUserGroups $mesUserGroups);

    /**
     * Remove mesUserGroups
     *
     * @param \MES\UserBundle\Entity\MesUserGroups $mesUserGroups
     */
    public function removeMesUserGroup(\MES\UserBundle\Entity\MesUserGroups $mesUserGroups);

    /**
     * Get mesUserGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMesUserGroups();

    /**
     * Add mesUserRoles
     *
     * @param \MES\SecurityBundle\Entity\MesUserRoles $mesUserRoles
     * @return MesUser
     */
    public function addMesUserRole(\MES\SecurityBundle\Entity\MesUserRoles $mesUserRoles);

    /**
     * Remove mesUserRoles
     *
     * @param \MES\SecurityBundle\Entity\MesUserRoles $mesUserRoles
     */
    public function removeMesUserRole(\MES\SecurityBundle\Entity\MesUserRoles $mesUserRoles);

    /**
     * Get mesUserRoles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMesUserRoles();
}
