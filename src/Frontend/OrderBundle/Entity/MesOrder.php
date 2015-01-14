<?php

namespace Frontend\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MesOrder
 *
 * @ORM\Table(name="mes_order", indexes={@ORM\Index(name="fk_order_order_state1_idx", columns={"order_state_id"})})
 * @ORM\Entity
 */
class MesOrder
{
    const PRZ = 'Poczta Polska Paczka24 / Extra24 przelew';
    const POB = 'Poczta Polska Paczka24 / Extra24 za pobraniem';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="shiping_number", type="string", length=255, nullable=true)
     */
    private $shipingNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=100, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=100, nullable=false)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="building", type="string", length=45, nullable=false)
     */
    private $building;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=100, nullable=false)
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=100, nullable=false)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=100, nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="shipping", type="string", length=100, nullable=false)
     */
    private $shipping;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="array", nullable=true)
     */
    private $company;

    /**
     * @var \OrderState
     *
     * @ORM\ManyToOne(targetEntity="OrderState")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_state_id", referencedColumnName="id")
     * })
     */
    private $orderState;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="MES\UserBundle\Entity\MesUser", mappedBy="mesUserOrder")
     */
    private $mesUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="OrderProducts", inversedBy="order", cascade={"persist"})
     * @ORM\JoinTable(name="order_has_order_products",
     *   joinColumns={
     *     @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="order_products_id", referencedColumnName="id")
     *   }
     * )
     */
    private $orderProducts;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mesUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orderProducts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return MesOrder
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return MesOrder
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
     * Set shipingNumber
     *
     * @param string $shipingNumber
     * @return MesOrder
     */
    public function setShipingNumber($shipingNumber)
    {
        $this->shipingNumber = $shipingNumber;

        return $this;
    }

    /**
     * Get shipingNumber
     *
     * @return string 
     */
    public function getShipingNumber()
    {
        return $this->shipingNumber;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return MesOrder
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return MesOrder
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
     * Set building
     *
     * @param string $building
     * @return MesOrder
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return string 
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set town
     *
     * @param string $town
     * @return MesOrder
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string 
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return MesOrder
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
     * Set email
     *
     * @param string $email
     * @return MesOrder
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return MesOrder
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set shipping
     *
     * @param string $shipping
     * @return MesOrder
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Get shipping
     *
     * @return string 
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set company
     *
     * @param array $company
     * @return MesOrder
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return array 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set orderState
     *
     * @param \Frontend\OrderBundle\Entity\OrderState $orderState
     * @return MesOrder
     */
    public function setOrderState(\Frontend\OrderBundle\Entity\OrderState $orderState = null)
    {
        $this->orderState = $orderState;

        return $this;
    }

    /**
     * Get orderState
     *
     * @return \Frontend\OrderBundle\Entity\OrderState 
     */
    public function getOrderState()
    {
        return $this->orderState;
    }

    /**
     * Add mesUser
     *
     * @param \MES\UserBundle\Entity\MesUser $mesUser
     * @return MesOrder
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

    /**
     * Add orderProducts
     *
     * @param \Frontend\OrderBundle\Entity\OrderProducts $orderProducts
     * @return MesOrder
     */
    public function addOrderProduct(\Frontend\OrderBundle\Entity\OrderProducts $orderProducts)
    {
        $this->orderProducts[] = $orderProducts;

        return $this;
    }

    /**
     * Remove orderProducts
     *
     * @param \Frontend\OrderBundle\Entity\OrderProducts $orderProducts
     */
    public function removeOrderProduct(\Frontend\OrderBundle\Entity\OrderProducts $orderProducts)
    {
        $this->orderProducts->removeElement($orderProducts);
    }

    /**
     * Get orderProducts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderProducts()
    {
        return $this->orderProducts;
    }
}
