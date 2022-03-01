<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'theme', targetEntity: Assortiment::class)]
    private $assortiment;

    #[ORM\OneToMany(mappedBy: 'theme', targetEntity: Produit::class)]
    private $produit;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;
    
    public function __construct()
    {
        $this->assortiment = new ArrayCollection();
        $this->produit = new ArrayCollection();
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

    /**
     * @return Collection|Assortiment[]
     */
    public function getAssortiment(): Collection
    {
        return $this->assortiment;
    }

    public function addAssortiment(Assortiment $assortiment): self
    {
        if (!$this->assortiment->contains($assortiment)) {
            $this->assortiment[] = $assortiment;
            $assortiment->setTheme($this);
        }

        return $this;
    }

    public function removeAssortiment(Assortiment $assortiment): self
    {
        if ($this->assortiment->removeElement($assortiment)) {
            // set the owning side to null (unless already changed)
            if ($assortiment->getTheme() === $this) {
                $assortiment->setTheme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
            $produit->setTheme($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getTheme() === $this) {
                $produit->setTheme(null);
            }
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
