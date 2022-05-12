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
     * @ORM\Column(type="boolean")
     */
    private $resolved = false;

    /**
     * @ORM\Column(type="integer")
     */
    private $majNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateBugFix;

    /**
     * @ORM\OneToOne(targetEntity=Bug::class, mappedBy="idBugFix", cascade={"persist", "remove"})
     */
    private $bugId;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBugId(): ?Bug
    {
        return $this->bugId;
    }

    public function setBugId(?Bug $bugId): self
    {
        // unset the owning side of the relation if necessary
        if ($bugId === null && $this->bugId !== null) {
            $this->bugId->setIdBugFix(null);
        }

        // set the owning side of the relation if necessary
        if ($bugId !== null && $bugId->getIdBugFix() !== $this) {
            $bugId->setIdBugFix($this);
        }

        $this->bugId = $bugId;

        return $this;
    }
}
