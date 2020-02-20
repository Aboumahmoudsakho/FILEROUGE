<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomcompE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephoneE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NIN;

    /**
     * @ORM\Column(type="datetime")
     */
    private $EnvoyerAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomcompB;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephoneB;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $frais;

    /**
     * @ORM\Column(type="float")
     */
    private $comissionEtat;

    /**
     * @ORM\Column(type="float")
     */
    private $comissionEnvoi;

    /**
     * @ORM\Column(type="float")
     */
    private $comissionSystem;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeEnvoi;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Envoyeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NINB;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $retraitAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $comissionretrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     */
    private $donneur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $CmptD;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     */
    private $CmptC;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomcompE(): ?string
    {
        return $this->NomcompE;
    }

    public function setNomcompE(string $NomcompE): self
    {
        $this->NomcompE = $NomcompE;

        return $this;
    }

    public function getTelephoneE(): ?string
    {
        return $this->telephoneE;
    }

    public function setTelephoneE(string $telephoneE): self
    {
        $this->telephoneE = $telephoneE;

        return $this;
    }

    public function getNIN(): ?string
    {
        return $this->NIN;
    }

    public function setNIN(string $NIN): self
    {
        $this->NIN = $NIN;

        return $this;
    }

    public function getEnvoyerAt(): ?\DateTimeInterface
    {
        return $this->EnvoyerAt;
    }

    public function setEnvoyerAt(\DateTimeInterface $EnvoyerAt): self
    {
        $this->EnvoyerAt = $EnvoyerAt;

        return $this;
    }

    public function getNomcompB(): ?string
    {
        return $this->NomcompB;
    }

    public function setNomcompB(string $NomcompB): self
    {
        $this->NomcompB = $NomcompB;

        return $this;
    }

    public function getTelephoneB(): ?string
    {
        return $this->telephoneB;
    }

    public function setTelephoneB(string $telephoneB): self
    {
        $this->telephoneB = $telephoneB;

        return $this;
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

    public function getFrais(): ?string
    {
        return $this->frais;
    }

    public function setFrais(string $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getComissionEtat(): ?float
    {
        return $this->comissionEtat;
    }

    public function setComissionEtat(float $comissionEtat): self
    {
        $this->comissionEtat = $comissionEtat;

        return $this;
    }

    public function getComissionEnvoi(): ?float
    {
        return $this->comissionEnvoi;
    }

    public function setComissionEnvoi(float $comissionEnvoi): self
    {
        $this->comissionEnvoi = $comissionEnvoi;

        return $this;
    }

    public function getComissionSystem(): ?float
    {
        return $this->comissionSystem;
    }

    public function setComissionSystem(float $comissionSystem): self
    {
        $this->comissionSystem = $comissionSystem;

        return $this;
    }

    public function getCodeEnvoi(): ?string
    {
        return $this->codeEnvoi;
    }

    public function setCodeEnvoi(string $codeEnvoi): self
    {
        $this->codeEnvoi = $codeEnvoi;

        return $this;
    }

    public function getEnvoyeur(): ?User
    {
        return $this->Envoyeur;
    }

    public function setEnvoyeur(?User $Envoyeur): self
    {
        $this->Envoyeur = $Envoyeur;

        return $this;
    }

    public function getNINB(): ?string
    {
        return $this->NINB;
    }

    public function setNINB(?string $NINB): self
    {
        $this->NINB = $NINB;

        return $this;
    }

    public function getRetraitAt(): ?\DateTimeInterface
    {
        return $this->retraitAt;
    }

    public function setRetraitAt(?\DateTimeInterface $retraitAt): self
    {
        $this->retraitAt = $retraitAt;

        return $this;
    }

    public function getComissionretrait(): ?float
    {
        return $this->comissionretrait;
    }

    public function setComissionretrait(?float $comissionretrait): self
    {
        $this->comissionretrait = $comissionretrait;

        return $this;
    }

    public function getDonneur(): ?User
    {
        return $this->donneur;
    }

    public function setDonneur(?User $donneur): self
    {
        $this->donneur = $donneur;

        return $this;
    }

    public function getCmptD(): ?Compte
    {
        return $this->CmptD;
    }

    public function setCmptD(?Compte $CmptD): self
    {
        $this->CmptD = $CmptD;

        return $this;
    }

    public function getCmptC(): ?Compte
    {
        return $this->CmptC;
    }

    public function setCmptC(?Compte $CmptC): self
    {
        $this->CmptC = $CmptC;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
