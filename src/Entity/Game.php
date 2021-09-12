<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
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
    private $nameGame;

    /**
     * @ORM\Column(type="integer")
     */
    private $yearOfPublication;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bugRating;

    /**
     * @ORM\ManyToOne(targetEntity=Editor::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idEditor;

    /**
     * @ORM\OneToMany(targetEntity=Bug::class, mappedBy="idGame")
     */
    private $bugs;

    public function __construct()
    {
        $this->bugs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameGame(): ?string
    {
        return $this->nameGame;
    }

    public function setNameGame(string $nameGame): self
    {
        $this->nameGame = $nameGame;

        return $this;
    }

    public function getYearOfPublication(): ?int
    {
        return $this->yearOfPublication;
    }

    public function setYearOfPublication(int $yearOfPublication): self
    {
        $this->yearOfPublication = $yearOfPublication;

        return $this;
    }

    public function getBugRating(): ?string
    {
        return $this->bugRating;
    }

    public function setBugRating(string $bugRating): self
    {
        $this->bugRating = $bugRating;

        return $this;
    }

    public function getIdEditor(): ?Editor
    {
        return $this->idEditor;
    }

    public function setIdEditor(?Editor $idEditor): self
    {
        $this->idEditor = $idEditor;

        return $this;
    }

    /**
     * @return Collection|Bug[]
     */
    public function getBugs(): Collection
    {
        return $this->bugs;
    }

    public function addBug(Bug $bug): self
    {
        if (!$this->bugs->contains($bug)) {
            $this->bugs[] = $bug;
            $bug->setIdGame($this);
        }

        return $this;
    }

    public function removeBug(Bug $bug): self
    {
        if ($this->bugs->removeElement($bug)) {
            // set the owning side to null (unless already changed)
            if ($bug->getIdGame() === $this) {
                $bug->setIdGame(null);
            }
        }

        return $this;
    }
}
