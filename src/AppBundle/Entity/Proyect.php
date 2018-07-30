<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyect
 *
 * @ORM\Table(name="Proyect")
 * @ORM\Entity
 */
class Proyect
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="string", length=100, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=false)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function getId() {
        return $this->id;
    }

    public function getImage() {
        return $this->image;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setUrl($url) {
        $this->url = $url;
    }
}
