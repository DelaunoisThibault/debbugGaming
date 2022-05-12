<?php

namespace App\Entity;

use App\Repository\BugRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BugRepository::class)
 */
class Bug
{
    const SEVERITY = ['Insignifiant', 'Faible', 'Modéré', 'Fort', 'Jeux condamné/lourdement impacté'];
    const FREQUENCY = ['Exceptionnel', 'Rare', 'Peu courant', 'Assez régulier', 'Fréquent', 'Systématique'];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="bugs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idGame;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bugs")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $idUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleBug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subtitleBug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $smallTextBug;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionTextBug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionImgBug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(choices=Bug::SEVERITY, message="La sévérité choisie est invalide ou n'existe pas")
     */
    private $severityBug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(choices=Bug::FREQUENCY, message="La fréquence choisie est invalide ou n'existe pas")
     */
    private $frequencyBug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published = false;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="idBug")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=BugSolution::class, mappedBy="idBug")
     */
    private $bugSolutions;

    /**
     * @ORM\OneToOne(targetEntity=BugFix::class, inversedBy="bugId", cascade={"persist", "remove"})
     */
    private $idBugFix;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->bugSolutions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdGame(): ?Game
    {
        return $this->idGame;
    }

    public function setIdGame(?Game $idGame): self
    {
        $this->idGame = $idGame;

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

    public function getTitleBug(): ?string
    {
        return $this->titleBug;
    }

    public function setTitleBug(string $titleBug): self
    {
        $this->titleBug = $titleBug;

        return $this;
    }

    public function getSubtitleBug(): ?string
    {
        return $this->subtitleBug;
    }

    public function setSubtitleBug(string $subtitleBug): self
    {
        $this->subtitleBug = $subtitleBug;

        return $this;
    }

    public function getSmallTextBug(): ?string
    {
        return $this->smallTextBug;
    }

    public function setSmallTextBug(string $smallTextBug): self
    {
        $this->smallTextBug = $smallTextBug;

        return $this;
    }

    public function getDescriptionTextBug(): ?string
    {
        return $this->descriptionTextBug;
    }

    public function setDescriptionTextBug(string $descriptionTextBug): self
    {
        $this->descriptionTextBug = $descriptionTextBug;

        return $this;
    }

    public function getDescriptionImgBug(): ?string
    {
        return $this->descriptionImgBug;
    }

    public function setDescriptionImgBug(string $descriptionImgBug): self
    {
        $this->descriptionImgBug = $descriptionImgBug;

        return $this;
    }

    public function getSeverityBug(): ?string
    {
        return $this->severityBug;
    }

    public function setSeverityBug(string $severityBug): self
    {
        $this->severityBug = $severityBug;

        return $this;
    }

    public function getFrequencyBug(): ?string
    {
        return $this->frequencyBug;
    }

    public function setFrequencyBug(string $frequencyBug): self
    {
        $this->frequencyBug = $frequencyBug;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setIdBug($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getIdBug() === $this) {
                $comment->setIdBug(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BugSolution[]
     */
    public function getBugSolutions(): Collection
    {
        return $this->bugSolutions;
    }

    public function addBugSolution(BugSolution $bugSolution): self
    {
        if (!$this->bugSolutions->contains($bugSolution)) {
            $this->bugSolutions[] = $bugSolution;
            $bugSolution->setIdBug($this);
        }

        return $this;
    }

    public function removeBugSolution(BugSolution $bugSolution): self
    {
        if ($this->bugSolutions->removeElement($bugSolution)) {
            // set the owning side to null (unless already changed)
            if ($bugSolution->getIdBug() === $this) {
                $bugSolution->setIdBug(null);
            }
        }

        return $this;
    }

    public function getIdBugFix(): ?BugFix
    {
        return $this->idBugFix;
    }

    public function setIdBugFix(?BugFix $idBugFix): self
    {
        $this->idBugFix = $idBugFix;

        return $this;
    }
}
