<?php

namespace MES\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MesUserRoles
 *
 * @ORM\Table(name="mes_user_roles")
 * @ORM\Entity
 */
class MesUserRoles {

    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="\MES\UserBundle\Entity\MesUser", mappedBy="mesUserRoles")
     */
    private $mesUser;

    /**
     * Constructor
     */
    public function __construct() {
        $this->mesUser = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return MesUserRoles
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
     * Add mesUser
     *
     * @param \MES\UserBundle\Entity\MesUser $mesUser
     * @return MesUserRoles
     */
    public function addMesUser(\MES\UserBundle\Entity\MesUser $mesUser) {
        $this->mesUser[] = $mesUser;

        return $this;
    }

    /**
     * Remove mesUser
     *
     * @param \MES\UserBundle\Entity\MesUser $mesUser
     */
    public function removeMesUser(\MES\UserBundle\Entity\MesUser $mesUser) {
        $this->mesUser->removeElement($mesUser);
    }

    /**
     * Get mesUser
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMesUser() {
        return $this->mesUser;
    }

}
