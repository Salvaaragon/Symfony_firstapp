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
     * @ORM\Column(name="isRead", type="boolean", nullable=false)
     */
    private $isRead;

    
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

    public function getIsRead() {
        return $this->isRead;
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

    public function setIsRead($isRead) {
        $this->isRead = $isRead;
    }

    public function setDate($date) {
        $this->date = $date;
    }

}
