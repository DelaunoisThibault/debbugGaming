<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $textComments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity=Bug::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idBug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextComments(): ?string
    {
        return $this->textComments;
    }

    public function setTextComments(string $textComments): self
    {
        $this->textComments = $textComments;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdBug(): ?Bug
    {
        return $this->idBug;
    }

    public function setIdBug(?Bug $idBug): self
    {
        $this->idBug = $idBug;

        return $this;
    }
}
