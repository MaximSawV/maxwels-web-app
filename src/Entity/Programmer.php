<?php

namespace App\Entity;

use App\Repository\ProgrammerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $U_ID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Done_Requests;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Positive_Votes;

    /**
     * @ORM\OneToMany(targetEntity=Request::class, mappedBy="Done_by")
     */
    private $requests;

    public function __construct()
    {
        $this->requests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUID(): ?User
    {
        return $this->U_ID;
    }

    public function setUID(User $U_ID): self
    {
        $this->U_ID = $U_ID;

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

    public function getDoneRequests(): ?int
    {
        return $this->Done_Requests;
    }

    public function setDoneRequests(?int $Done_Requests): self
    {
        $this->Done_Requests = $Done_Requests;

        return $this;
    }

    public function getPositiveVotes(): ?int
    {
        return $this->Positive_Votes;
    }

    public function setPositiveVotes(?int $Positive_Votes): self
    {
        $this->Positive_Votes = $Positive_Votes;

        return $this;
    }

    /**
     * @return Collection|Request[]
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->requests->contains($request)) {
            $this->requests[] = $request;
            $request->setDoneBy($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getDoneBy() === $this) {
                $request->setDoneBy(null);
            }
        }

        return $this;
    }
}
