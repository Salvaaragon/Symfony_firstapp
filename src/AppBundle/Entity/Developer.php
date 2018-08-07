<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Developer
 *
 * @ORM\Table(name="Developer")
 * @ORM\Entity
 */
class Developer
{
    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surname", type="string", length=100, nullable=true)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="personal_information", type="string", length=512, nullable=false)
     */
    private $personalInformation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="linkedin", type="string", length=100, nullable=true)
     */
    private $linkedin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="twitter", type="string", length=100, nullable=true)
     */
    private $twitter;

    /**
     * @var string|null
     *
     * @ORM\Column(name="github", type="string", length=100, nullable=true)
     */
    private $github;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
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
     * Get surname
     *
     * @return string
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * Get personalInformation
     *
     * @return string
     */
    public function getPersonalInformation() {
        return $this->personalInformation;
    }

    /**
     * Get linkedin
     *
     * @return string
     */
    public function getLinkedin() {
        return $this->linkedin;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter() {
        return $this->twitter;
    }
    
    /**
     * Get github
     *
     * @return string
     */
    public function getGithub() {
        return $this->github;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     */
    public function setImage($image) {
        $this->image = $image;
    }
    
    /**
     * Set name
     *
     * @param string $name
     *
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     */
    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function setPersonalInformation($personalInformation) {
        $this->personalInformation = $personalInformation;
    }

    public function setLinkedin($linkedin) {
        $this->linkedin = $linkedin;
    }

    public function setTwitter($twitter) {
        $this->twitter = $twitter;
    }

    public function setGithub($github) {
        $this->github = $github;
    }

}
