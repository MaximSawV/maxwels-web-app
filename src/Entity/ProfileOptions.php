<?php

namespace App\Entity;

use App\Repository\ProfileOptionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileOptionsRepository::class)
 */
class ProfileOptions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="profileOptions", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="boolean")
     */
    private $PublicContact;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ShowStatus;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Hidden;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Darkmode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getPublicContact(): ?bool
    {
        return $this->PublicContact;
    }

    public function setPublicContact(bool $PublicContact): self
    {
        $this->PublicContact = $PublicContact;

        return $this;
    }

    public function getShowStatus(): ?bool
    {
        return $this->ShowStatus;
    }

    public function setShowStatus(bool $ShowStatus): self
    {
        $this->ShowStatus = $ShowStatus;

        return $this;
    }

    public function getHidden(): ?bool
    {
        return $this->Hidden;
    }

    public function setHidden(bool $Hidden): self
    {
        $this->Hidden = $Hidden;

        return $this;
    }

    public function getDarkmode(): ?bool
    {
        return $this->Darkmode;
    }

    public function setDarkmode(bool $Darkmode): self
    {
        $this->Darkmode = $Darkmode;

        return $this;
    }
}
