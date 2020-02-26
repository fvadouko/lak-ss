<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PointeusesRepository")
 */
class Pointeuses
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $arrivals;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $departures;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="events")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArrivals(): ?\DateTimeInterface
    {
        return $this->arrivals;
    }

    public function setArrivals(\DateTimeInterface $arrivals): self
    {
        $this->arrivals = $arrivals;

        return $this;
    }

    public function getDepartures(): ?\DateTimeInterface
    {
        return $this->departures;
    }

    public function setDepartures(?\DateTimeInterface $departures): self
    {
        $this->departures = $departures;

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
