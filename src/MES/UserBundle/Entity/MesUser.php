<?php

namespace MES\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MesUser
 *
 * @ORM\Table(name="mes_user", uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"}), @ORM\UniqueConstraint(name="lusername_UNIQUE", columns={"username"})})
 * @ORM\Entity
 */
class MesUser implements \MES\SecurityBundle\Security\MesUserInterface {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="success_login_count", type="integer", nullable=false)
     */
    private $successLoginCount = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="failed_login_count", type="integer", nullable=false)
     */
    private $failedLoginCount = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=128, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_success", type="datetime", nullable=true)
     */
    private $lastSuccess;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_fail", type="datetime", nullable=true)
     */
    private $lastFail;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=128, nullable=false)
     */
    private $surname;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive = '1';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="MesUserGroups", inversedBy="mesUser")
     * @ORM\JoinTable(name="mes_user_has_mes_user_groups",
     *   joinColumns={
     *     @ORM\JoinColumn(name="mes_user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="mes_user_groups_id", referencedColumnName="id")
     *   }
     * )
     */
    private $mesUserGroups;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\MES\SecurityBundle\Entity\MesUserRoles", inversedBy="mesUser")
     * @ORM\JoinTable(name="mes_user_has_mes_user_roles",
     *   joinColumns={
     *     @ORM\JoinColumn(name="mes_user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="mes_user_roles_id", referencedColumnName="id")
     *   }
     * )
     */
    private $mesUserRoles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="\Frontend\OrderBundle\Entity\MesOrder", inversedBy="mesUser")
     * @ORM\JoinTable(name="mes_user_has_order",
     *   joinColumns={
     *     @ORM\JoinColumn(name="mes_user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     *   }
     * )
     */
    private $mesUserOrder;

    /**
     * Constructor
     */
    public function __construct() {
        $this->mesUserGroups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mesUserRoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateCreated = new \DateTime();
        $this->mesUserOrder = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set successLoginCount
     *
     * @param integer $successLoginCount
     * @return MesUser
     */
    public function setSuccessLoginCount($successLoginCount) {
        $this->successLoginCount = $successLoginCount;

        return $this;
    }

    /**
     * Get successLoginCount
     *
     * @return integer 
     */
    public function getSuccessLoginCount() {
        return $this->successLoginCount;
    }

    /**
     * Set failedLoginCount
     *
     * @param integer $failedLoginCount
     * @return MesUser
     */
    public function setFailedLoginCount($failedLoginCount) {
        $this->failedLoginCount = $failedLoginCount;

        return $this;
    }

    /**
     * Get failedLoginCount
     *
     * @return integer 
     */
    public function getFailedLoginCount() {
        return $this->failedLoginCount;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return MesUser
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set login
     *
     * @param string $username
     * @return MesUser
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return MesUser
     */
    public function setSalt($salt) {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return MesUser
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return MesUser
     */
    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated() {
        return $this->dateCreated;
    }

    /**
     * Set lastSuccess
     *
     * @param \DateTime $lastSuccess
     * @return MesUser
     */
    public function setLastSuccess($lastSuccess) {
        $this->lastSuccess = $lastSuccess;

        return $this;
    }

    /**
     * Get lastSuccess
     *
     * @return \DateTime 
     */
    public function getLastSuccess() {
        return $this->lastSuccess;
    }

    /**
     * Set lastFail
     *
     * @param \DateTime $lastFail
     * @return MesUser
     */
    public function setLastFail($lastFail) {
        $this->lastFail = $lastFail;

        return $this;
    }

    /**
     * Get lastFail
     *
     * @return \DateTime 
     */
    public function getLastFail() {
        return $this->lastFail;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return MesUser
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return MesUser
     */
    public function setSurname($surname) {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return MesUser
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * Add mesUserGroups
     *
     * @param \MES\UserBundle\Entity\MesUserGroups $mesUserGroups
     * @return MesUser
     */
    public function addMesUserGroup(\MES\UserBundle\Entity\MesUserGroups $mesUserGroups) {
        $this->mesUserGroups[] = $mesUserGroups;

        return $this;
    }

    /**
     * Remove mesUserGroups
     *
     * @param \MES\UserBundle\Entity\MesUserGroups $mesUserGroups
     */
    public function removeMesUserGroup(\MES\UserBundle\Entity\MesUserGroups $mesUserGroups) {
        $this->mesUserGroups->removeElement($mesUserGroups);
    }

    /**
     * Get mesUserGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMesUserGroups() {
        return $this->mesUserGroups;
    }

    /**
     * Add mesUserRoles
     *
     * @param \MES\SecurityBundle\Entity\MesUserRoles $mesUserRoles
     * @return MesUser
     */
    public function addMesUserRole(\MES\SecurityBundle\Entity\MesUserRoles $mesUserRoles) {
        $this->mesUserRoles[] = $mesUserRoles;

        return $this;
    }

    /**
     * Remove mesUserRoles
     *
     * @param \MES\SecurityBundle\Entity\MesUserRoles $mesUserRoles
     */
    public function removeMesUserRole(\MES\SecurityBundle\Entity\MesUserRoles $mesUserRoles) {
        $this->mesUserRoles->removeElement($mesUserRoles);
    }

    /**
     * Get mesUserRoles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMesUserRoles() {
        return $this->mesUserRoles;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        $roles = [];
        foreach ($this->getMesUserRoles() as $role) {
            $roles[] = $role->getName();
        }
        return $roles;
    }

    /**
     * 
     * @return type
     */
    public function getMesUserOrder() {
        return $this->mesUserOrder;
    }

    /**
     * 
     * @param \Frontend\OrderBundle\Entity\MesOrder $mesUserOrder
     * @return \MES\UserBundle\Entity\MesUser
     */
    public function addMesUserOrder(\Frontend\OrderBundle\Entity\MesOrder $mesUserOrder) {
        $this->mesUserOrder[] = $mesUserOrder;
        return $this;
    }

    /**
     * 
     * @param \Frontend\OrderBundle\Entity\MesOrder $mesUserOrder
     * @return \MES\UserBundle\Entity\MesUser
     */
    public function removeMesUserOrder(\Frontend\OrderBundle\Entity\MesOrder $mesUserOrder) {
        $this->mesUserOrder->removeElement($mesUserOrder);
        return $this;
    }

}
