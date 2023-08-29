<?php

namespace App\Entity;

use App\Repository\SallesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SallesRepository::class)]
class Salles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'salles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Batiments $batiments = null;

    #[ORM\OneToMany(mappedBy: 'salles', targetEntity: Demandes::class)]
    private Collection $demande;

    public function __construct()
    {
        $this->demande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBatiments(): ?Batiments
    {
        return $this->batiments;
    }

    public function setBatiments(?Batiments $batiments): static
    {
        $this->batiments = $batiments;

        return $this;
    }

    /**
     * @return Collection<int, Demandes>
     */
    public function getDemande(): Collection
    {
        return $this->demande;
    }

    public function addDemande(Demandes $demande): static
    {
        if (!$this->demande->contains($demande)) {
            $this->demande->add($demande);
            $demande->setSalles($this);
        }

        return $this;
    }

    public function removeDemande(Demandes $demande): static
    {
        if ($this->demande->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getSalles() === $this) {
                $demande->setSalles(null);
            }
        }

        return $this;
    }
}
