<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PointeusesRepository")
 * @ApiResource
 */
class Pointeuses
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("user:read")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("user:read")
     */
    private $arrivals;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("user:read")
     */
    private $departures;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pointeuses")
     * @Groups("user:read")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $month;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $week;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $overtimes;

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
        //$this->arrivals = new DateTime();
        return $this;
    }

    public function getDepartures(): ?\DateTimeInterface
    {
        return $this->departures;
    }

    public function setDepartures(?\DateTimeInterface $departures): self
    {
        //$this->departures = new DateTime();
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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(?string $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(?int $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getOvertimes(): ?int
    {
        return $this->overtimes;
    }

    public function setOvertimes(?int $overtimes): self
    {
        $this->overtimes = $overtimes;

        return $this;
    }
}
