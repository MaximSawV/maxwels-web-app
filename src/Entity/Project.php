<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
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
    private $Title;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $Deadline;

    /**
     * @ORM\OneToMany(targetEntity=Request::class, mappedBy="Part_of_Project")
     */
    private $requests;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="projects")
     */
    private $Requested_by;

    /**
     * @ORM\ManyToMany(targetEntity=Programmer::class, inversedBy="projects")
     */
    private $Working_on;

    public function __construct()
    {
        $this->requests = new ArrayCollection();
        $this->Requested_by = new ArrayCollection();
        $this->Working_on = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

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
            $request->setPartOfProject($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getPartOfProject() === $this) {
                $request->setPartOfProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getRequestedBy(): Collection
    {
        return $this->Requested_by;
    }

    public function addRequestedBy(User $requestedBy): self
    {
        if (!$this->Requested_by->contains($requestedBy)) {
            $this->Requested_by[] = $requestedBy;
        }

        return $this;
    }

    public function removeRequestedBy(User $requestedBy): self
    {
        $this->Requested_by->removeElement($requestedBy);

        return $this;
    }

    /**
     * @return Collection|Programmer[]
     */
    public function getWorkingOn(): Collection
    {
        return $this->Working_on;
    }

    public function addWorkingOn(Programmer $workingOn): self
    {
        if (!$this->Working_on->contains($workingOn)) {
            $this->Working_on[] = $workingOn;
        }

        return $this;
    }

    public function removeWorkingOn(Programmer $workingOn): self
    {
        $this->Working_on->removeElement($workingOn);

        return $this;
    }
}
