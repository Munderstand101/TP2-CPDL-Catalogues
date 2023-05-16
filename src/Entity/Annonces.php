<?php

namespace App\Entity;

use App\Repository\AnnoncesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnnoncesRepository::class)]
class Annonces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("read")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("read")]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    #[Groups("read")]
    private ?Produit $produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
