<?php

namespace App\Entity;

use App\Repository\ChatMessageRepository;
use App\Repository\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ChatMessage::class, mappedBy="in_chat", orphanRemoval=true)
     */
    private $chatMessages;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_group;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $group_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $group_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $group_description;

    /**
     * @ORM\OneToMany(targetEntity=ChatParticipant::class, mappedBy="in_chat", orphanRemoval=true)
     */
    private $chatParticipants;


    public function __construct()
    {
        $this->chatParticipants = new ArrayCollection();
        $this->chatMessages = new ArrayCollection();
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
            $chatMessage->setInChat($this);
        }

        return $this;
    }

    public function removeChatMessage(ChatMessage $chatMessage): self
    {
        if ($this->chatMessages->removeElement($chatMessage)) {
            // set the owning side to null (unless already changed)
            if ($chatMessage->getInChat() === $this) {
                $chatMessage->setInChat(null);
            }
        }

        return $this;
    }

    public function getIsGroup(): ?bool
    {
        return $this->is_group;
    }

    public function setIsGroup(bool $is_group): self
    {
        $this->is_group = $is_group;

        return $this;
    }

    public function getGroupName(): ?string
    {
        return $this->group_name;
    }

    public function setGroupName(?string $group_name): self
    {
        $this->group_name = $group_name;

        return $this;
    }

    public function getGroupImage(): ?string
    {
        return $this->group_image;
    }

    public function setGroupImage(?string $group_image): self
    {
        $this->group_image = $group_image;

        return $this;
    }

    public function getGroupDescription(): ?string
    {
        return $this->group_description;
    }

    public function setGroupDescription(?string $group_description): self
    {
        $this->group_description = $group_description;

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
            $chatParticipant->setInChat($this);
        }

        return $this;
    }

    public function removeChatParticipant(ChatParticipant $chatParticipant): self
    {
        if ($this->chatParticipants->removeElement($chatParticipant)) {
            // set the owning side to null (unless already changed)
            if ($chatParticipant->getInChat() === $this) {
                $chatParticipant->setInChat(null);
            }
        }

        return $this;
    }
}
