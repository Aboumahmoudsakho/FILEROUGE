<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AffectationRepository")
 */
class Affectation
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
    private $affectedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $expiredAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="affectations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Comptconcerne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="affectations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $useraffecter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAffectedAt(): self
    {
        return $this->affectedAt;
    }

    public function setAffectedAt(string $affectedAt): self
    {
        $this->affectedAt = $affectedAt;

        return $this;
    }

    public function getExpiredAt(): self
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(string $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    public function getComptconcerne(): ?Compte
    {
        return $this->Comptconcerne;
    }

    public function setComptconcerne(?Compte $Comptconcerne): self
    {
        $this->Comptconcerne = $Comptconcerne;

        return $this;
    }

    public function getUseraffecter(): ?User
    {
        return $this->useraffecter;
    }

    public function setUseraffecter(?User $useraffecter): self
    {
        $this->useraffecter = $useraffecter;

        return $this;
    }
}
