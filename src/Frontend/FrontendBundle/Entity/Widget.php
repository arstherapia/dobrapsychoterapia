<?php

namespace Frontend\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Widget
 *
 * @ORM\Table(name="widget", uniqueConstraints={@ORM\UniqueConstraint(name="widget_type_id_UNIQUE", columns={"widget_type_id"})})
 * @ORM\Entity
 */
class Widget
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
     * @var \WidgetType
     *
     * @ORM\ManyToOne(targetEntity="WidgetType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="widget_type_id", referencedColumnName="id")
     * })
     */
    private $widgetType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movies", inversedBy="widget")
     * @ORM\JoinTable(name="widget_has_movies",
     *   joinColumns={
     *     @ORM\JoinColumn(name="widget_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   }
     * )
     */
    private $movies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set widgetType
     *
     * @param \Frontend\FrontendBundle\Entity\WidgetType $widgetType
     * @return Widget
     */
    public function setWidgetType(\Frontend\FrontendBundle\Entity\WidgetType $widgetType = null)
    {
        $this->widgetType = $widgetType;

        return $this;
    }

    /**
     * Get widgetType
     *
     * @return \Frontend\FrontendBundle\Entity\WidgetType 
     */
    public function getWidgetType()
    {
        return $this->widgetType;
    }

    /**
     * Add movies
     *
     * @param \Frontend\FrontendBundle\Entity\Movies $movies
     * @return Widget
     */
    public function addMovie(\Frontend\FrontendBundle\Entity\Movies $movies)
    {
        $this->movies[] = $movies;

        return $this;
    }

    /**
     * Remove movies
     *
     * @param \Frontend\FrontendBundle\Entity\Movies $movies
     */
    public function removeMovie(\Frontend\FrontendBundle\Entity\Movies $movies)
    {
        $this->movies->removeElement($movies);
    }

    /**
     * Get movies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovies()
    {
        return $this->movies;
    }
}
