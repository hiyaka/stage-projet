<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DemandesRepository;
use Symfony\Component\Validator\Constraints as Assert; // Use rajouté par moi meme

#[ORM\Entity(repositoryClass: DemandesRepository::class)]
class Demandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Veuillez écrire votre demande", groups: ['with-demandes-description'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'Demandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'demande')]
    #[ORM\JoinColumn(nullable: true)]
    #[Assert\NotBlank(message: "Veuillez sélectioner une salle", groups: ['with-demandes-salles'])]
    private ?Salles $salles = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $rapport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSalles(): ?Salles
    {
        return $this->salles;
    }

    public function setSalles(?Salles $salles): static
    {
        $this->salles = $salles;

        return $this;
    }

    public function getRapport(): ?string
    {
        return $this->rapport;
    }

    public function setRapport(?string $rapport): static
    {
        $this->rapport = $rapport;

        return $this;
    }
}
