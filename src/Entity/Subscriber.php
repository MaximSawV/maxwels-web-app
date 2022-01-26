<?php

namespace App\Entity;

use App\Repository\SubscriberRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass=SubscriberRepository::class)
 */
class Subscriber
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\Column(name="email_address", type="string", length=255, unique=true)
     * @ORM\OneToOne(targetEntity="User")
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $Donation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $donation_interval;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $form_of_donation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="date")
     */
    private $first_donation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $last_donation;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_of_donations;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    public function __toString()
    {
        return (string) $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(User $user): self
    {
        $this->email = $user->getEmail();

        return $this;
    }

    public function getDonation(): ?int
    {
        return $this->Donation;
    }

    public function setDonation(int $Donation): self
    {
        $this->Donation = $Donation;

        return $this;
    }

    public function getDonationInterval(): ?string
    {
        return $this->donation_interval;
    }

    public function setDonationInterval(string $donation_interval): self
    {
        $this->donation_interval = $donation_interval;

        return $this;
    }

    public function getFormOfDonation(): ?string
    {
        return $this->form_of_donation;
    }

    public function setFormOfDonation(string $form_of_donation): self
    {
        $this->form_of_donation = $form_of_donation;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getFirstDonation(): ?\DateTimeInterface
    {
        return $this->first_donation;
    }

    public function setFirstDonation(\DateTimeInterface $first_donation): self
    {
        $this->first_donation = $first_donation;

        return $this;
    }

    public function getLastDonation(): ?\DateTimeInterface
    {
        return $this->last_donation;
    }

    public function setLastDonation(?\DateTimeInterface $last_donation): self
    {
        $this->last_donation = $last_donation;

        return $this;
    }

    public function getNumberOfDonations(): ?int
    {
        return $this->number_of_donations;
    }

    public function setNumberOfDonations(int $number_of_donations): self
    {
        $this->number_of_donations = $number_of_donations;

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
}
