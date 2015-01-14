<?php

namespace Frontend\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderState
 *
 * @ORM\Table(name="order_state")
 * @ORM\Entity
 */
class OrderState {

    const RECIVED = 1;
    const ACCEPTED = 2;
    const PREPARING = 3;
    const SEND = 4;
    const CANCELED = 5;

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
     * @return OrderState
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

}
