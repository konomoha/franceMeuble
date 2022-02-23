<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $couleur;

    #[ORM\Column(type: 'string', length: 255)]
    private $matiere;

    #[ORM\Column(type: 'float', nullable: true)]
    private $longueur;

    #[ORM\Column(type: 'float', nullable: true)]
    private $largeur;

    #[ORM\Column(type: 'float', nullable: true)]
    private $hauteur;

    #[ORM\Column(type: 'float', nullable: true)]
    private $profondeur;

    #[ORM\Column(type: 'float', nullable: true)]
    private $diametre;

    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $stock;

    #[ORM\ManyToOne(targetEntity: Souscategorie::class, inversedBy: 'produits')]
    private $souscategorie;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\ManyToMany(targetEntity: Assortiment::class, inversedBy: 'produits')]
    private $assortiment;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo2;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo3;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo4;

    public function __construct()
    {
        $this->assortiment = new ArrayCollection();
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

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getLargeur(): ?float
    {
        return $this->largeur;
    }

    public function setLargeur(?float $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getHauteur(): ?float
    {
        return $this->hauteur;
    }

    public function setHauteur(?float $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getProfondeur(): ?float
    {
        return $this->profondeur;
    }

    public function setProfondeur(?float $profondeur): self
    {
        $this->profondeur = $profondeur;

        return $this;
    }

    public function getDiametre(): ?float
    {
        return $this->diametre;
    }

    public function setDiametre(?float $diametre): self
    {
        $this->diametre = $diametre;

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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getSouscategorie(): ?Souscategorie
    {
        return $this->souscategorie;
    }

    public function setSouscategorie(?Souscategorie $souscategorie): self
    {
        $this->souscategorie = $souscategorie;

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
        }

        return $this;
    }

    public function removeAssortiment(Assortiment $assortiment): self
    {
        $this->assortiment->removeElement($assortiment);

        return $this;
    }

    public function getPhoto2(): ?string
    {
        return $this->photo2;
    }

    public function setPhoto2(?string $photo2): self
    {
        $this->photo2 = $photo2;

        return $this;
    }

    public function getPhoto3(): ?string
    {
        return $this->photo3;
    }

    public function setPhoto3(?string $photo3): self
    {
        $this->photo3 = $photo3;

        return $this;
    }

    public function getPhoto4(): ?string
    {
        return $this->photo4;
    }

    public function setPhoto4(?string $photo4): self
    {
        $this->photo4 = $photo4;

        return $this;
    }
}
