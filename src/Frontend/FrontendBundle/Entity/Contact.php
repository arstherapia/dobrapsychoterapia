<?php

namespace Frontend\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Therapist
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity
 */
class Contact {

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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=false)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=4096, nullable=true)
     */
    private $message;

    /**
     * @var boolean
     *
     * @ORM\Column(name="copy", type="boolean", nullable=false)
     */
    private $copy = 0;

    /**
     * @return boolean
     */
    public function getCopy() {
        return $this->copy;
    }

    /**
     * @param boolean $copy
     * @return \Frontend\FrontendBundle\Entity\Contact
     */
    public function setCopy($copy) {
        $this->copy = $copy;
        return $this;
    }

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \Frontend\FrontendBundle\Entity\Contact
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $email
     * @return \Frontend\FrontendBundle\Entity\Contact
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @param string $subject
     * @return \Frontend\FrontendBundle\Entity\Contact
     */
    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param string $message
     * @return \Frontend\FrontendBundle\Entity\Contact
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

}
