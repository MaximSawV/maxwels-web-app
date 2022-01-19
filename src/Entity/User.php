<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;


    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Subscribed;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $customer_or_programmer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity=ProfileOptions::class, mappedBy="User", cascade={"persist", "remove"})
     */
    private $profileOptions;

    /**
     * @ORM\OneToMany(targetEntity=UserRelationship::class, mappedBy="referingUser")
     */
    private $userRelationships;

    /**
     * @ORM\OneToMany(targetEntity=ChatParticipant::class, mappedBy="user", orphanRemoval=true)
     */
    private $chatParticipants;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $loggedOutTime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $loggedInTime;

    public function __construct()
    {
        $this->userRelationships = new ArrayCollection();
        $this->chatParticipants = new ArrayCollection();
    }


    public function __toString()
    {
        return (string) $this->getUserIdentifier();
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): string
    {
        return (string) $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return ($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getSubscribed(): ?bool
    {
        return $this->Subscribed;
    }

    public function setSubscribed(bool $Subscribed): self
    {
        $this->Subscribed = $Subscribed;

        return $this;
    }

    public function getCustomerOrProgrammer(): ?string
    {
        return $this->customer_or_programmer;
    }

    public function setCustomerOrProgrammer(string $customer_or_programmer): self
    {
        $this->customer_or_programmer = $customer_or_programmer;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProfileOptions(): ?ProfileOptions
    {
        return $this->profileOptions;
    }

    public function setProfileOptions(ProfileOptions $profileOptions): self
    {
        // set the owning side of the relation if necessary
        if ($profileOptions->getUser() !== $this) {
            $profileOptions->setUser($this);
        }

        $this->profileOptions = $profileOptions;

        return $this;
    }

    /**
     * @return Collection|UserRelationship[]
     */
    public function getUserRelationships(): Collection
    {
        return $this->userRelationships;
    }

    public function addUserRelationship(UserRelationship $userRelationship): self
    {
        if (!$this->userRelationships->contains($userRelationship)) {
            $this->userRelationships[] = $userRelationship;
            $userRelationship->setReferingUser($this);
        }

        return $this;
    }

    public function removeUserRelationship(UserRelationship $userRelationship): self
    {
        if ($this->userRelationships->removeElement($userRelationship)) {
            // set the owning side to null (unless already changed)
            if ($userRelationship->getReferingUser() === $this) {
                $userRelationship->setReferingUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|ChatParticipant[]
     */
    public function getChatParticipants(): Collection
    {
        return $this->chatParticipants;
    }

    public function addChatParticipant(ChatParticipant $chatParticipant): self
    {
        if (!$this->chatParticipants->contains($chatParticipant)) {
            $this->chatParticipants[] = $chatParticipant;
            $chatParticipant->setUser($this);
        }

        return $this;
    }

    public function removeChatParticipant(ChatParticipant $chatParticipant): self
    {
        if ($this->chatParticipants->removeElement($chatParticipant)) {
            // set the owning side to null (unless already changed)
            if ($chatParticipant->getUser() === $this) {
                $chatParticipant->setUser(null);
            }
        }

        return $this;
    }

    public function getLoggedOutTime(): ?\DateTimeInterface
    {
        return $this->loggedOutTime;
    }

    public function setLoggedOutTime(\DateTimeInterface $loggedOutTime): self
    {
        $this->loggedOutTime = $loggedOutTime;

        return $this;
    }

    public function getLoggedInTime(): ?\DateTimeInterface
    {
        return $this->loggedInTime;
    }

    public function setLoggedInTime(\DateTimeInterface $loggedInTime): self
    {
        $this->loggedInTime = $loggedInTime;

        return $this;
    }
}
