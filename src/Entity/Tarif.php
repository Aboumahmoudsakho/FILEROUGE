<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TarifRepository")
 */
class Tarif
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
    private $borninf;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bornsup;

    /**
     * @ORM\Column(type="float")
     */
    private $frais;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorninf(): ?string
    {
        return $this->borninf;
    }

    public function setBorninf(string $borninf): self
    {
        $this->borninf = $borninf;

        return $this;
    }

    public function getBornsup(): ?string
    {
        return $this->bornsup;
    }

    public function setBornsup(string $bornsup): self
    {
        $this->bornsup = $bornsup;

        return $this;
    }

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
    }
}
