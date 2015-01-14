<?php

namespace MES\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MesCompany
 *
 * @ORM\Table(name="mes_company", indexes={@ORM\Index(name="fk_mes_profile_mes_user1_idx", columns={"mes_user_id"})})
 * @ORM\Entity
 */
class MesCompany
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nip", type="string", length=255, nullable=false)
     */
    private $nip;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=false)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="building_number", type="string", length=100, nullable=false)
     */
    private $buildingNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="apartment_number", type="string", length=50, nullable=true)
     */
    private $apartmentNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=75, nullable=false)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=45, nullable=false)
     */
    private $telephone;

    /**
     * @var \MesUser
     *
     * @ORM\ManyToOne(targetEntity="MesUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mes_user_id", referencedColumnName="id")
     * })
     */
    private $mesUser;



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
     * @return MesCompany
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
     * Set nip
     *
     * @param string $nip
     * @return MesCompany
     */
    public function setNip($nip)
    {
        $this->nip = $nip;

        return $this;
    }

    /**
     * Get nip
     *
     * @return string 
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return MesCompany
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set buildingNumber
     *
     * @param string $buildingNumber
     * @return MesCompany
     */
    public function setBuildingNumber($buildingNumber)
    {
        $this->buildingNumber = $buildingNumber;

        return $this;
    }

    /**
     * Get buildingNumber
     *
     * @return string 
     */
    public function getBuildingNumber()
    {
        return $this->buildingNumber;
    }

    /**
     * Set apartmentNumber
     *
     * @param string $apartmentNumber
     * @return MesCompany
     */
    public function setApartmentNumber($apartmentNumber)
    {
        $this->apartmentNumber = $apartmentNumber;

        return $this;
    }

    /**
     * Get apartmentNumber
     *
     * @return string 
     */
    public function getApartmentNumber()
    {
        return $this->apartmentNumber;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return MesCompany
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return MesCompany
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return MesCompany
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set mesUser
     *
     * @param \MES\UserBundle\Entity\MesUser $mesUser
     * @return MesCompany
     */
    public function setMesUser(\MES\UserBundle\Entity\MesUser $mesUser = null)
    {
        $this->mesUser = $mesUser;

        return $this;
    }

    /**
     * Get mesUser
     *
     * @return \MES\UserBundle\Entity\MesUser 
     */
    public function getMesUser()
    {
        return $this->mesUser;
    }
}
