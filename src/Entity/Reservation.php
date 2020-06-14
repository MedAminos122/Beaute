<?php

namespace App\Entity;

use App\Entity\Client;
use App\Entity\Service;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
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
    private $dater;

    /**
     * @ORM\Column(type="string", length=254)
     *  @Assert\Length(min=5,minMessage="votre prénom est trop long")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="reservations")
     */
    private $cli;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="reservations")
     */
    private $service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDater(): ?\DateTimeInterface
    {
        return $this->dater;
    }

    public function setDater(\DateTimeInterface $dater): self
    {
        $this->dater = $dater;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCli(): ?Client
    {
        return $this->cli;
    }

    public function setCli(?Client $cli): self
    {
        $this->cli = $cli;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
    public function __toString()
    {
        return ''.$this->id;
    }
}
