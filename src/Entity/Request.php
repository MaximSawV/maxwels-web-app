<?php

namespace App\Entity;

use App\Repository\RequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 */
class Request
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="requests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Created_by;

    /**
     * @ORM\Column(type="date")
     */
    private $Creation_Date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status;

    /**
     * @ORM\Column(type="text")
     */
    private $Context;

    /**
     * @ORM\ManyToOne(targetEntity=Programmer::class, inversedBy="requests")
     */
    private $Done_by;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Rating;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $Done_on;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedBy(): ?User
    {
        return $this->Created_by;
    }

    public function setCreatedBy(?User $Created_by): self
    {
        $this->Created_by = $Created_by;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->Creation_Date;
    }

    public function setCreationDate(\DateTimeInterface $Creation_Date): self
    {
        $this->Creation_Date = $Creation_Date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getContext(): ?string
    {
        return $this->Context;
    }

    public function setContext(string $Context): self
    {
        $this->Context = $Context;

        return $this;
    }

    public function getDoneBy(): ?Programmer
    {
        return $this->Done_by;
    }

    public function setDoneBy(?Programmer $Done_by): self
    {
        $this->Done_by = $Done_by;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->Rating;
    }

    public function setRating(?string $Rating): self
    {
        $this->Rating = $Rating;

        return $this;
    }

    public function getDoneOn(): ?\DateTimeInterface
    {
        return $this->Done_on;
    }

    public function setDoneOn(?\DateTimeInterface $Done_on): self
    {
        $this->Done_on = $Done_on;

        return $this;
    }
}
