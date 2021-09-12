<?php

namespace App\Entity;

use App\Repository\ContactMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactMessageRepository::class)
 */
class ContactMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameContactMessage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mailContact;

    /**
     * @ORM\Column(type="text")
     */
    private $textContactMessage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameContactMessage(): ?string
    {
        return $this->nameContactMessage;
    }

    public function setNameContactMessage(string $nameContactMessage): self
    {
        $this->nameContactMessage = $nameContactMessage;

        return $this;
    }

    public function getMailContact(): ?string
    {
        return $this->mailContact;
    }

    public function setMailContact(string $mailContact): self
    {
        $this->mailContact = $mailContact;

        return $this;
    }

    public function getTextContactMessage(): ?string
    {
        return $this->textContactMessage;
    }

    public function setTextContactMessage(string $textContactMessage): self
    {
        $this->textContactMessage = $textContactMessage;

        return $this;
    }
}
