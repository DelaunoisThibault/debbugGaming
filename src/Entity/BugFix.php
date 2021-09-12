<?php

namespace App\Entity;

use App\Repository\BugFixRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BugFixRepository::class)
 */
class BugFix
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Bug::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idBug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $resolved;

    /**
     * @ORM\Column(type="integer")
     */
    private $majNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateBugFix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBug(): ?Bug
    {
        return $this->idBug;
    }

    public function setIdBug(Bug $idBug): self
    {
        $this->idBug = $idBug;

        return $this;
    }

    public function getResolved(): ?bool
    {
        return $this->resolved;
    }

    public function setResolved(bool $resolved): self
    {
        $this->resolved = $resolved;

        return $this;
    }

    public function getMajNumber(): ?int
    {
        return $this->majNumber;
    }

    public function setMajNumber(int $majNumber): self
    {
        $this->majNumber = $majNumber;

        return $this;
    }

    public function getDateBugFix(): ?\DateTimeInterface
    {
        return $this->dateBugFix;
    }

    public function setDateBugFix(\DateTimeInterface $dateBugFix): self
    {
        $this->dateBugFix = $dateBugFix;

        return $this;
    }
}
