<?php

namespace App\Entity;

use App\Repository\BugSolutionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BugSolutionRepository::class)
 */
class BugSolution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Bug::class, inversedBy="bugSolutions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idBug;

    /**
     * @ORM\Column(type="text")
     */
    private $textBugSolution;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgBugSolution;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleBugSolution;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTextBugSolution(): ?string
    {
        return $this->textBugSolution;
    }

    public function setTextBugSolution(string $textBugSolution): self
    {
        $this->textBugSolution = $textBugSolution;

        return $this;
    }

    public function getImgBugSolution(): ?string
    {
        return $this->imgBugSolution;
    }

    public function setImgBugSolution(string $imgBugSolution): self
    {
        $this->imgBugSolution = $imgBugSolution;

        return $this;
    }

    public function getTitleBugSolution(): ?string
    {
        return $this->titleBugSolution;
    }

    public function setTitleBugSolution(string $titleBugSolution): self
    {
        $this->titleBugSolution = $titleBugSolution;

        return $this;
    }
}
