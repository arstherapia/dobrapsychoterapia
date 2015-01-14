<?php

namespace Frontend\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderProducts
 *
 * @ORM\Table(name="order_products", indexes={@ORM\Index(name="IDX_5242B8EB53F590A4", columns={"movies_id"})})
 * @ORM\Entity
 */
class OrderProducts
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
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="product_price_nett", type="float", precision=10, scale=0, nullable=false)
     */
    private $productPriceNett;

    /**
     * @var float
     *
     * @ORM\Column(name="product_price_gross", type="float", precision=10, scale=0, nullable=true)
     */
    private $productPriceGross;
    
    /**
     * @var \Frontend\FrontendBundle\Entity\Movies
     *
     * @ORM\ManyToOne(targetEntity="Frontend\FrontendBundle\Entity\Movies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     * })
     */
    private $movies;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="MesOrder", mappedBy="orderProducts")
     */
    private $order;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->order = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set quantity
     *
     * @param integer $quantity
     * @return OrderProducts
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set productPriceNett
     *
     * @param float $productPriceNett
     * @return OrderProducts
     */
    public function setProductPriceNett($productPriceNett)
    {
        $this->productPriceNett = $productPriceNett;

        return $this;
    }

    /**
     * Get productPriceNett
     *
     * @return float 
     */
    public function getProductPriceNett()
    {
        return $this->productPriceNett;
    }

    /**
     * Set productPriceGross
     *
     * @param float $productPriceGross
     * @return OrderProducts
     */
    public function setProductPriceGross($productPriceGross)
    {
        $this->productPriceGross = $productPriceGross;

        return $this;
    }

    /**
     * Get productPriceGross
     *
     * @return float 
     */
    public function getProductPriceGross()
    {
        return $this->productPriceGross;
    }

    /**
     * Set movies
     *
     * @param \Frontend\FrontendBundle\Entity\Moviess $movies
     * @return OrderProducts
     */
    public function setMovies(\Frontend\FrontendBundle\Entity\Movies $movies = null)
    {
        $this->movies = $movies;

        return $this;
    }

    /**
     * Get movies
     *
     * @return \Frontend\FrontendBundle\Entity\Movies
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
     * Add order
     *
     * @param \Frontend\OrderBundle\Entity\MesOrder $order
     * @return OrderProducts
     */
    public function addOrder(\Frontend\OrderBundle\Entity\MesOrder $order)
    {
        $this->order[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \Frontend\OrderBundle\Entity\MesOrder $order
     */
    public function removeOrder(\Frontend\OrderBundle\Entity\MesOrder $order)
    {
        $this->order->removeElement($order);
    }

    /**
     * Get order
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
