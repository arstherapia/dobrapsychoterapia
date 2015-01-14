<?php

namespace Frontend\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Problems
 *
 * @ORM\Table(name="problems")
 * @ORM\Entity
 */
class Problems {

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
     * @ORM\Column(name="name", type="text", length=65535, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movies", mappedBy="problems")
     */
    private $movies;

    /**
     * Constructor
     */
    public function __construct() {
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Problems
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
     * Add movies
     *
     * @param \Frontend\FrontendBundle\Entity\Movies $movies
     * @return Problems
     */
    public function addMovie(\Frontend\FrontendBundle\Entity\Movies $movies) {
        $this->movies[] = $movies;

        return $this;
    }

    /**
     * Remove movies
     *
     * @param \Frontend\FrontendBundle\Entity\Movies $movies
     */
    public function removeMovie(\Frontend\FrontendBundle\Entity\Movies $movies) {
        $this->movies->removeElement($movies);
    }

    /**
     * Get movies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovies() {
        return $this->movies;
    }

}
