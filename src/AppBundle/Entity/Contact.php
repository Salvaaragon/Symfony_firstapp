<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 *
 * @ORM\Table(name="Contact")
 * @ORM\Entity
 */
class Contact
{
    /**
     * @var string
     * @Assert\Email(
     *     message = "El correo electrónico '{{ value }}' no es válido.",
     *     checkMX = true
     * )
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=1024, nullable=false)
     */
    private $message;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var bool
     * @ORM\Column(name="isReaded", type="boolean", nullable=false)
     */
    private $isReaded;

    
    /**
     * @var date
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getIsReaded() {
        return $this->isReaded;
    }

    public function getDate() {
        return $this->date;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setIsReaded($isReaded) {
        $this->isReaded = $isReaded;
    }

    public function setDate($date) {
        $this->date = $date;
    }

}
