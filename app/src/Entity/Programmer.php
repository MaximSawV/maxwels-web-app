<?php

namespace App\Entity;

use App\Repository\ProgrammerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgrammerRepository::class)
 */
class Programmer
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
    private $Status;

    /**
     * @ORM\Column(type="integer")
     */
    private $Done_Requests;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Rating;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDoneRequests(): ?int
    {
        return $this->Done_Requests;
    }

    public function setDoneRequests(int $Done_Requests): self
    {
        $this->Done_Requests = $Done_Requests;

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
}
