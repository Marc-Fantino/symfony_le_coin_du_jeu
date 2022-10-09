<?php

namespace App\Entity;

use App\Repository\DistributeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DistributeurRepository::class)
 */
class Distributeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_distributeur;

    /**
     * @ORM\ManyToMany(targetEntity=BluelineSymfony::class, mappedBy="distributeur")
     */
    private $bluelineSymfonies;

    public function __construct()
    {
        $this->bluelineSymfonies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDistributeur(): ?string
    {
        return $this->nom_distributeur;
    }

    public function setNomDistributeur(string $nom_distributeur): self
    {
        $this->nom_distributeur = $nom_distributeur;

        return $this;
    }

    /**
     * @return Collection<int, BluelineSymfony>
     */
    public function getBluelineSymfonies(): Collection
    {
        return $this->bluelineSymfonies;
    }

    public function addBluelineSymfony(BluelineSymfony $bluelineSymfony): self
    {
        if (!$this->bluelineSymfonies->contains($bluelineSymfony)) {
            $this->bluelineSymfonies[] = $bluelineSymfony;
            $bluelineSymfony->addDistributeur($this);
        }

        return $this;
    }

    public function removeBluelineSymfony(BluelineSymfony $bluelineSymfony): self
    {
        if ($this->bluelineSymfonies->removeElement($bluelineSymfony)) {
            $bluelineSymfony->removeDistributeur($this);
        }

        return $this;
    }
    public function __toString()
    {
       return $this->nom_distributeur; 
    }

}
