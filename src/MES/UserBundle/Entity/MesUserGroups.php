<?php

namespace MES\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MesUserGroups
 *
 * @ORM\Table(name="mes_user_groups")
 * @ORM\Entity
 */
class MesUserGroups
{
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
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="MesUser", mappedBy="mesUserGroups")
     */
    private $mesUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mesUser = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return MesUserGroups
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add mesUser
     *
     * @param \MES\UserBundle\Entity\MesUser $mesUser
     * @return MesUserGroups
     */
    public function addMesUser(\MES\UserBundle\Entity\MesUser $mesUser)
    {
        $this->mesUser[] = $mesUser;

        return $this;
    }

    /**
     * Remove mesUser
     *
     * @param \MES\UserBundle\Entity\MesUser $mesUser
     */
    public function removeMesUser(\MES\UserBundle\Entity\MesUser $mesUser)
    {
        $this->mesUser->removeElement($mesUser);
    }

    /**
     * Get mesUser
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMesUser()
    {
        return $this->mesUser;
    }
}
