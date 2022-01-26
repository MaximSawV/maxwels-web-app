<?php

namespace App\Entity;

use App\Repository\UserRelationshipRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRelationshipRepository::class)
 */
class UserRelationship
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
    private $isFriend = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBlocked = false;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority = false;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userRelationships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $reference_user;

    public function __toString()
    {
        return (string) $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsFriend(): bool
    {
        return $this->isFriend;
    }

    public function setIsFriend(bool $isFriend): self
    {
        $this->isFriend = $isFriend;

        return $this;
    }

    public function getIsBlocked(): bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(bool $isBlocked): self
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getReferenceUser(): ?User
    {
        return $this->reference_user;
    }

    public function setReferenceUser(?User $reference_user): self
    {
        $this->reference_user = $reference_user;

        return $this;
    }
}
