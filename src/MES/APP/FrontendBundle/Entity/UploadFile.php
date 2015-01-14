<?php

namespace MES\APP\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
 * @ORM\Entity(repositoryClass="MES\APP\FrontendBundle\Entity\Repository\UploadFileRepository")
 * @ORM\Table(name="upload_file")
 */
class UploadFile
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=256, nullable=true)
     */
    private $path;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;
    
    public function __construct(){
        $this->dateCreated = new \DateTime();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

}