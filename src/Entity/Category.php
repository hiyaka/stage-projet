<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Demandes::class)]
    private Collection $Demandes;

    public function __construct()
    {
        $this->Demandes = new ArrayCollection(); // ArrayCollection est une surcouche d'un tableau
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

    /**
     * @return Collection<int, Demandes>
     */
    public function getDemandes(): Collection
    {
        return $this->Demandes;
    }

    public function addDemande(Demandes $demande): static
    {
        if (!$this->Demandes->contains($demande)) {
            $this->Demandes->add($demande);
            $demande->setCategory($this);
        }

        return $this;
    }

    public function removeDemande(Demandes $demande): static
    {
        if ($this->Demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getCategory() === $this) {
                $demande->setCategory(null);
            }
        }

        return $this;
    }
}
