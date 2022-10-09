<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 */
class Categories
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
    private $nom_categorie;

    /**
     * @ORM\OneToMany(targetEntity=BluelineSymfony::class, mappedBy="categorie")
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

    public function getNomCategorie(): ?string
    {
        return $this->nom_categorie;
    }

    public function setNomCategorie(string $nom_categorie): self
    {
        $this->nom_categorie = $nom_categorie;

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
            $bluelineSymfony->setCategorie($this);
        }

        return $this;
    }

    public function removeBluelineSymfony(BluelineSymfony $bluelineSymfony): self
    {
        if ($this->bluelineSymfonies->removeElement($bluelineSymfony)) {
            // set the owning side to null (unless already changed)
            if ($bluelineSymfony->getCategorie() === $this) {
                $bluelineSymfony->setCategorie(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
       return $this->nom_categorie; 
    }
}
