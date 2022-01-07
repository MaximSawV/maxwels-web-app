<?php

namespace App\Entity;

use App\Repository\MaxwelsAdminRepository;
use App\myPHPClasses\MaxwelsAdminManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaxwelsAdminRepository::class)
 */
class MaxwelsAdmin
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
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $granted_by;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $admin_key;

    private $adminManager;

    public function __construct(MaxwelsAdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGrantedBy(): ?User
    {
        return $this->granted_by;
    }

    public function setGrantedBy(User $Granted_by): self
    {
        $this->granted_by = $Granted_by;
        return $this;
    }

    public function getAdminKey(): ?string
    {
        return $this->admin_key;
    }

    public function setAdminKey(): self
    {
        $this->admin_key = $this->adminManager->createAdminKey($this);

        return $this;
    }
}
