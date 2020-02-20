<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $deposerAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $depositeur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Ccrediteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDeposerAt(): ?\DateTimeInterface
    {
        return $this->deposerAt;
    }

    public function setDeposerAt(\DateTimeInterface $deposerAt): self
    {
        $this->deposerAt = $deposerAt;

        return $this;
    }

    public function getDepositeur(): ?User
    {
        return $this->depositeur;
    }

    public function setDepositeur(?User $depositeur): self
    {
        $this->depositeur = $depositeur;

        return $this;
    }

    public function getCcrediteur(): ?Compte
    {
        return $this->Ccrediteur;
    }

    public function setCcrediteur(?Compte $Ccrediteur): self
    {
        $this->Ccrediteur = $Ccrediteur;

        return $this;
    }
}
