<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ApiResource
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("user:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("user:read")
     */
    private $location;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("user:read")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("user:read")
     */
    private $endt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("user:read")
     */
    private $allday;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("user:read")
     */
    private $timezone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     */
    private $repeat;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("user:read")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="events")
     * @Groups("user:read")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEndt(): ?\DateTimeInterface
    {
        return $this->endt;
    }

    public function setEndt(\DateTimeInterface $endt): self
    {
        $this->endt = $endt;

        return $this;
    }

    public function getAllday(): ?bool
    {
        return $this->allday;
    }

    public function setAllday(bool $allday): self
    {
        $this->allday = $allday;

        return $this;
    }

    public function getTimezone(): ?bool
    {
        return $this->timezone;
    }

    public function setTimezone(bool $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getRepeat(): ?string
    {
        return $this->repeat;
    }

    public function setRepeat(string $repeat): self
    {
        $this->repeat = $repeat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
