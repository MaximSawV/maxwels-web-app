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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userRelationships")
     * @ORM\JoinColumn(nullable=false, columnDefinition="id")
     */
    private $referingUser;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userRelationships")
     * @ORM\JoinColumn(nullable=false, columnDefinition="id")
     */
    private $referencedUser;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferingUser(): ?User
    {
        return $this->referingUser;
    }

    public function setReferingUser(?User $referingUser): self
    {
        $this->referingUser = $referingUser;

        return $this;
    }

    public function getReferencedUser(): ?User
    {
        return $this->referingUser;
    }

    public function setReferencedUser(?User $referencedUser): self
    {
        $this->referencedUser = $referencedUser;

        return $this;
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
}
