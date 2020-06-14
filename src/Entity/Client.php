<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=254)
     * 
     * @Assert\Length(min=5,minMessage="votre prénom est trop long")
     */
    private $nomcli;

    /**
     * @ORM\Column(type="string", length=254)
     * @Assert\Length(min=5,minMessage="votre prénom est trop long")
     * 
     */
    private $prenomcli;

    /**
     * @ORM\Column(type="string", length=254)
     * @Assert\Length(min=5,minMessage="votre prénom est trop long")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=254)
     * @Assert\Email(message="c'est un champs de mail")
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="cli")
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomcli(): ?string
    {
        return $this->nomcli;
    }

    public function setNomcli(string $nomcli): self
    {
        $this->nomcli = $nomcli;

        return $this;
    }

    public function getPrenomcli(): ?string
    {
        return $this->prenomcli;
    }

    public function setPrenomcli(string $prenomcli): self
    {
        $this->prenomcli = $prenomcli;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setCli($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getCli() === $this) {
                $reservation->setCli(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return "".$this->id;
    }
}
