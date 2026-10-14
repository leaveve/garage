<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $annee = null;

    #[ORM\Column]
    private ?int $kilometrage = null;

    #[ORM\Column]
    private ?int $puissanceCh = null;

    #[ORM\Column(length: 50)]
    private ?string $couleur = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $couleurHex = null;

    #[ORM\Column(nullable: true)]
    private ?int $prixVente = null;

    #[ORM\Column(nullable: true)]
    private ?int $prixLocationJour = null;

    #[ORM\Column(nullable: true)]
    private ?int $caution = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?bool $aVendre = null;

    #[ORM\Column]
    private ?bool $aLouer = null;

    #[ORM\Column(length: 20)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Modele $modele = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Transmission $transmission = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Carburant $carburant = null;

    /**
     * @var Collection<int, RendezVous>
     */
    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'voiture')]
    private Collection $rendezVouses;

    public function __construct()
    {
        $this->rendezVouses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): static
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getPuissanceCh(): ?int
    {
        return $this->puissanceCh;
    }

    public function setPuissanceCh(int $puissanceCh): static
    {
        $this->puissanceCh = $puissanceCh;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getCouleurHex(): ?string
    {
        return $this->couleurHex;
    }

    public function setCouleurHex(?string $couleurHex): static
    {
        $this->couleurHex = $couleurHex;

        return $this;
    }

    public function getPrixVente(): ?int
    {
        return $this->prixVente;
    }

    public function setPrixVente(?int $prixVente): static
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getPrixLocationJour(): ?int
    {
        return $this->prixLocationJour;
    }

    public function setPrixLocationJour(?int $prixLocationJour): static
    {
        $this->prixLocationJour = $prixLocationJour;

        return $this;
    }

    public function getCaution(): ?int
    {
        return $this->caution;
    }

    public function setCaution(?int $caution): static
    {
        $this->caution = $caution;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function isAVendre(): ?bool
    {
        return $this->aVendre;
    }

    public function setAVendre(bool $aVendre): static
    {
        $this->aVendre = $aVendre;

        return $this;
    }

    public function isALouer(): ?bool
    {
        return $this->aLouer;
    }

    public function setALouer(bool $aLouer): static
    {
        $this->aLouer = $aLouer;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getTransmission(): ?Transmission
    {
        return $this->transmission;
    }

    public function setTransmission(?Transmission $transmission): static
    {
        $this->transmission = $transmission;

        return $this;
    }

    public function getCarburant(): ?Carburant
    {
        return $this->carburant;
    }

    public function setCarburant(?Carburant $carburant): static
    {
        $this->carburant = $carburant;

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): static
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses->add($rendezVouse);
            $rendezVouse->setVoiture($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): static
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getVoiture() === $this) {
                $rendezVouse->setVoiture(null);
            }
        }

        return $this;
    }
}
