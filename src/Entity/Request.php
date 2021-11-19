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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="created_by")
     */
    private $Created_by;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="working_on")
     */
    private $Working_on;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status;

    /**
     * @ORM\Column(type="date")
     */
    private $Created_on;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $Deadline;

    /**
     * @ORM\Column(type="text")
     */
    private $Context;

    /**
     * @ORM\Column(type="integer")
     */
    private $Vote;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedBy(): ?User
    {
        return $this->Created_by;
    }

    public function setCreatedBy(User $Created_by): self
    {
        $this->Created_by = $Created_by;

        return $this;
    }

    public function getWorkingOn(): ?User
    {
        return $this->Working_on;
    }

    public function setWorkingOn(User $Working_on): self
    {
        $this->Working_on = $Working_on;

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

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->Created_on;
    }

    public function setCreatedOn(\DateTimeInterface $Created_on): self
    {
        $this->Created_on = $Created_on;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->Deadline;
    }

    public function setDeadline(?\DateTimeInterface $Deadline): self
    {
        $this->Deadline = $Deadline;

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

    public function getVote(): ?int
    {
        return $this->Vote;
    }

    public function setVote(int $Vote): self
    {
        $this->Vote = $Vote;

        return $this;
    }
}
