<?php

namespace Frontend\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movies
 *
 * @ORM\Table(name="movies", indexes={@ORM\Index(name="IDX_C61EED30F82209BB", columns={"movie_status_id"})})
 * @ORM\Entity
 */
class Movies {

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
     * @ORM\Column(name="cover", type="string", length=255, nullable=true)
     */
    private $cover;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="description_short", type="text", length=65535, nullable=true)
     */
    private $descriptionShort;

    /**
     * @var float
     *
     * @ORM\Column(name="proffesional_price", type="float", precision=10, scale=0, nullable=false)
     */
    private $proffesionalPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="individual_price", type="float", precision=10, scale=0, nullable=false)
     */
    private $individualPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="minutes", type="integer", nullable=false)
     */
    private $minutes;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_of_discs", type="integer", nullable=false)
     */
    private $numberOfDiscs;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @var \MovieStatus
     *
     * @ORM\ManyToOne(targetEntity="MovieStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movie_status_id", referencedColumnName="id")
     * })
     */
    private $movieStatus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Catagory", inversedBy="movies")
     * @ORM\JoinTable(name="catagory_has_movies",
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   },
     *   joinColumns={
     *     @ORM\JoinColumn(name="catagory_id", referencedColumnName="id")
     *   }
     * )
     */
    private $catagory;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Languages", inversedBy="movies")
     * @ORM\JoinTable(name="movies_has_languages",
     *   joinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="languages_id", referencedColumnName="id")
     *   }
     * )
     */
    private $languages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Problems", inversedBy="movies")
     * @ORM\JoinTable(name="problems_has_movies", 
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   },
     *   joinColumns={
     *     @ORM\JoinColumn(name="problems_id", referencedColumnName="id")
     *   }
     * )
     */
    private $problems;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Therapist", inversedBy="movies")
     * @ORM\JoinTable(name="therapist_has_movies",
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   },
     *   joinColumns={
     *     @ORM\JoinColumn(name="therapist_id", referencedColumnName="id")
     *   },
     * )
     */
    private $therapist;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movies", inversedBy="movies")
     * @ORM\JoinTable(name="movies_has_similar",
     *   joinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="similar_id", referencedColumnName="id")
     *   }
     * )
     */
    private $similar;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movies", mappedBy="similar")
     */
    private $movies;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Widget", mappedBy="movies")
     */
    private $widget;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_describtion", type="text", nullable=false)
     */
    private $seoDescribtion;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_keywords", type="text", nullable=false)
     */
    private $seoKeywords;

    /**
     * Constructor
     */
    public function __construct() {
        $this->catagory = new \Doctrine\Common\Collections\ArrayCollection();
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->similar = new \Doctrine\Common\Collections\ArrayCollection();
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->problems = new \Doctrine\Common\Collections\ArrayCollection();
        $this->therapist = new \Doctrine\Common\Collections\ArrayCollection();
        $this->widget = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Movies
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
     * Set cover
     *
     * @param string $cover
     * @return Movies
     */
    public function setCover($cover) {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string 
     */
    public function getCover() {
        return $this->cover;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Movies
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set descriptionShort
     *
     * @param string $descriptionShort
     * @return Movies
     */
    public function setDescriptionShort($descriptionShort) {
        $this->descriptionShort = $descriptionShort;

        return $this;
    }

    /**
     * Get descriptionShort
     *
     * @return string 
     */
    public function getDescriptionShort() {
        return $this->descriptionShort;
    }

    /**
     * Set proffesionalPrice
     *
     * @param float $proffesionalPrice
     * @return Movies
     */
    public function setProffesionalPrice($proffesionalPrice) {
        $this->proffesionalPrice = $proffesionalPrice;

        return $this;
    }

    /**
     * Get proffesionalPrice
     *
     * @return float 
     */
    public function getProffesionalPrice() {
        return $this->proffesionalPrice;
    }

    /**
     * Set individualPrice
     *
     * @param float $individualPrice
     * @return Movies
     */
    public function setIndividualPrice($individualPrice) {
        $this->individualPrice = $individualPrice;

        return $this;
    }

    /**
     * Get individualPrice
     *
     * @return float 
     */
    public function getIndividualPrice() {
        return $this->individualPrice;
    }

    /**
     * Set minutes
     *
     * @param integer $minutes
     * @return Movies
     */
    public function setMinutes($minutes) {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * Get minutes
     *
     * @return integer 
     */
    public function getMinutes() {
        return $this->minutes;
    }

    /**
     * Set numberOfDiscs
     *
     * @param integer $numberOfDiscs
     * @return Movies
     */
    public function setNumberOfDiscs($numberOfDiscs) {
        $this->numberOfDiscs = $numberOfDiscs;

        return $this;
    }

    /**
     * Get numberOfDiscs
     *
     * @return integer 
     */
    public function getNumberOfDiscs() {
        return $this->numberOfDiscs;
    }

    /**
     * Set video
     *
     * @param string $video
     * @return Movies
     */
    public function setVideo($video) {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo() {
        return $this->video;
    }

    /**
     * Set movieStatus
     *
     * @param \Frontend\FrontendBundle\Entity\MovieStatus $movieStatus
     * @return Movies
     */
    public function setMovieStatus(\Frontend\FrontendBundle\Entity\MovieStatus $movieStatus = null) {
        $this->movieStatus = $movieStatus;

        return $this;
    }

    /**
     * Get movieStatus
     *
     * @return \Frontend\FrontendBundle\Entity\MovieStatus 
     */
    public function getMovieStatus() {
        return $this->movieStatus;
    }

    /**
     * Add catagory
     *
     * @param \Frontend\FrontendBundle\Entity\Catagory $catagory
     * @return Movies
     */
    public function addCatagory(\Frontend\FrontendBundle\Entity\Catagory $catagory) {
        $this->catagory[] = $catagory;

        return $this;
    }

    /**
     * Remove catagory
     *
     * @param \Frontend\FrontendBundle\Entity\Catagory $catagory
     */
    public function removeCatagory(\Frontend\FrontendBundle\Entity\Catagory $catagory) {
        $this->catagory->removeElement($catagory);
    }

    /**
     * Get catagory
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCatagory() {
        return $this->catagory;
    }

    /**
     * Add languages
     *
     * @param \Frontend\FrontendBundle\Entity\Languages $languages
     * @return Movies
     */
    public function addLanguage(\Frontend\FrontendBundle\Entity\Languages $languages) {
        $this->languages[] = $languages;

        return $this;
    }

    /**
     * Remove languages
     *
     * @param \Frontend\FrontendBundle\Entity\Languages $languages
     */
    public function removeLanguage(\Frontend\FrontendBundle\Entity\Languages $languages) {
        $this->languages->removeElement($languages);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguages() {
        return $this->languages;
    }

    /**
     * Add problems
     *
     * @param \Frontend\FrontendBundle\Entity\Problems $problems
     * @return Movies
     */
    public function addProblem(\Frontend\FrontendBundle\Entity\Problems $problems) {
        $this->problems[] = $problems;

        return $this;
    }

    /**
     * Remove problems
     *
     * @param \Frontend\FrontendBundle\Entity\Problems $problems
     */
    public function removeProblem(\Frontend\FrontendBundle\Entity\Problems $problems) {
        $this->problems->removeElement($problems);
    }

    /**
     * Get problems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProblems() {
        return $this->problems;
    }

    /**
     * Add therapist
     *
     * @param \Frontend\FrontendBundle\Entity\Therapist $therapist
     * @return Movies
     */
    public function addTherapist(\Frontend\FrontendBundle\Entity\Therapist $therapist) {
        $this->therapist[] = $therapist;

        return $this;
    }

    /**
     * Remove therapist
     *
     * @param \Frontend\FrontendBundle\Entity\Therapist $therapist
     */
    public function removeTherapist(\Frontend\FrontendBundle\Entity\Therapist $therapist) {
        $this->therapist->removeElement($therapist);
    }

    /**
     * Get therapist
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTherapist() {
        return $this->therapist;
    }

    /**
     * Add similar
     *
     * @param \Frontend\FrontendBundle\Entity\Movies $similar
     * @return Movies
     */
    public function addSimilar(\Frontend\FrontendBundle\Entity\Movies $similar) {
        $this->similar[] = $similar;

        return $this;
    }

    /**
     * Remove similar
     *
     * @param \Frontend\FrontendBundle\Entity\Movies $similar
     */
    public function removeSimilar(\Frontend\FrontendBundle\Entity\Movies $similar) {
        $this->similar->removeElement($similar);
    }

    /**
     * Get similar
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSimilar() {
        return $this->similar;
    }

    /**
     * Get movies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovies() {
        return $this->movies;
    }

    /**
     * Get widget
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWidget() {
        return $this->widget;
    }

    /**
     * 
     * @return string
     */
    function getTitle() {
        return $this->title;
    }

    /**
     * 
     * @return string
     */
    function getSeoDescribtion() {
        return $this->seoDescribtion;
    }

    /**
     * 
     * @return string
     */
    function getSeoKeywords() {
        return $this->seoKeywords;
    }

    /**
     * 
     * @param string $title
     * @return \Frontend\FrontendBundle\Entity\Movies
     */
    function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * 
     * @param string $seoDescribtion
     * @return \Frontend\FrontendBundle\Entity\Movies
     */
    function setSeoDescribtion($seoDescribtion) {
        $this->seoDescribtion = $seoDescribtion;
        return $this;
    }

    /**
     * 
     * @param string $seoKeywords
     * @return \Frontend\FrontendBundle\Entity\Movies
     */
    function setSeoKeywords($seoKeywords) {
        $this->seoKeywords = $seoKeywords;
        return $this;
    }

}
