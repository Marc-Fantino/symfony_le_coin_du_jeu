<?php

namespace App\Entity;

use App\Repository\ReferenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferenceRepository::class)
 */
class Reference
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
    private $reference_numero;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferenceNumero(): ?string
    {
        return $this->reference_numero;
    }

    public function setReferenceNumero(string $reference_numero): self
    {
        $this->reference_numero = $reference_numero;

        return $this;
    }
    public function __toString()
    {
       return $this->reference_numero; 
    }
}
