<?php

namespace App\Entity;

use App\Repository\ChatParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatParticipantRepository::class)
 */
class ChatParticipant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ChatMessage::class, mappedBy="source")
     */
    private $chatMessages;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chatParticipants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $logged_out_since;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $logged_in_since;

    /**
     * @ORM\ManyToOne(targetEntity=Chat::class, inversedBy="chatParticipants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $in_chat;

    public function __construct()
    {
        $this->chatMessages = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|ChatMessage[]
     */
    public function getChatMessages(): Collection
    {
        return $this->chatMessages;
    }

    public function addChatMessage(ChatMessage $chatMessage): self
    {
        if (!$this->chatMessages->contains($chatMessage)) {
            $this->chatMessages[] = $chatMessage;
            $chatMessage->setSource($this);
        }

        return $this;
    }

    public function removeChatMessage(ChatMessage $chatMessage): self
    {
        if ($this->chatMessages->removeElement($chatMessage)) {
            // set the owning side to null (unless already changed)
            if ($chatMessage->getSource() === $this) {
                $chatMessage->setSource(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        $user->addChatParticipant($this);

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }


    public function getLoggedOutSince(): ?\DateTimeImmutable
    {
        return $this->logged_out_since;
    }

    public function setLoggedOutSince(\DateTimeImmutable $logged_out_since): self
    {
        $this->logged_out_since = $logged_out_since;

        return $this;
    }

    public function getLoggedInSince(): ?\DateTimeImmutable
    {
        return $this->logged_in_since;
    }

    public function setLoggedInSince(\DateTimeImmutable $logged_in_since): self
    {
        $this->logged_in_since = $logged_in_since;

        return $this;
    }

    public function getInChat(): ?Chat
    {
        return $this->in_chat;
    }

    public function setInChat(?Chat $in_chat): self
    {
        $this->in_chat = $in_chat;

        return $this;
    }
}