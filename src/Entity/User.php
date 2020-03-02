<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\IsNull;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource
 */
class User
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
     * @Assert\NotBlank(message="Le prenom est obligatoire")
     * @Assert\Length(min=3)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=3)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=3)
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=3)
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime")

     */
    private $createdAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $passwords;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hourlyrate;

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

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
 
            $this->createdAt = new \DateTime();


        return $this;
    }

    public function getPasswords(): ?string
    {
        return $this->passwords;
    }

    public function setPasswords(?string $passwords): self
    {
        // $options = ['cost' => 10,];
        // //$this->passwords = password_hash($passwords, PASSWORD_DEFAULT,$options);
        $this->passwords = $passwords;

        return $this;
    }

    public function getHourlyrate(): ?int
    {
        return $this->hourlyrate;
    }

    public function setHourlyrate(?int $hourlyrate): self
    {
        $this->hourlyrate = $hourlyrate;

        return $this;
    }




}