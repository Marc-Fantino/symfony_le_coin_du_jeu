<?php

namespace App\Entity;

use App\Repository\BluelineSymfonyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BluelineSymfonyRepository::class)
 */
class BluelineSymfony
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
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $disponible;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoCarte;

    /**
     * @ORM\OneToOne(targetEntity=Reference::class, cascade={"persist", "remove"})
     */
    private $numero;

    /**
     * @ORM\ManyToMany(targetEntity=Distributeur::class, inversedBy="bluelineSymfonies")
     */
    private $distributeur;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="bluelineSymfonies")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;


    public function __construct()
    {
        $this->distributeur = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDisponible(): ?\DateTimeInterface
    {
        return $this->disponible;
    }

    public function setDisponible(\DateTimeInterface $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPhotoCarte(): ?string
    {
        return $this->photoCarte;
    }

    public function setPhotoCarte(string $photoCarte): self
    {
        $this->photoCarte = $photoCarte;

        return $this;
    }

    public function getNumero(): ?Reference
    {
        return $this->numero;
    }

    public function setNumero(?Reference $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection<int, Distributeur>
     */
    public function getDistributeur(): Collection
    {
        return $this->distributeur;
    }

    public function addDistributeur(Distributeur $distributeur): self
    {
        if (!$this->distributeur->contains($distributeur)) {
            $this->distributeur[] = $distributeur;
        }

        return $this;
    }

    public function removeDistributeur(Distributeur $distributeur): self
    {
        $this->distributeur->removeElement($distributeur);

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

}
