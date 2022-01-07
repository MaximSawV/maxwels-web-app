<?php

namespace App\Entity;

use App\Repository\ChatMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatMessageRepository::class)
 */
class ChatMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ChatParticipant::class, inversedBy="chatMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_on;

    /**
     * @ORM\ManyToOne(targetEntity=Chat::class, inversedBy="chatMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $in_chat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?ChatParticipant
    {
        return $this->source;
    }

    public function setSource(?ChatParticipant $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->created_on;
    }

    public function setCreatedOn(\DateTimeInterface $created_on): self
    {
        $this->created_on = $created_on;

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
