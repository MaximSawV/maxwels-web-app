<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number_of_requests;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    public function __toString()
    {
        return (string) $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNumberOfRequests(): ?int
    {
        return $this->number_of_requests;
    }

    public function setNumberOfRequests(?int $number_of_requests): self
    {
        $this->number_of_requests = $number_of_requests;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
