<?php

namespace App\Entity;

use App\Repository\FavoritesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoritesRepository::class)]
class Favorites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUser = null;

    #[ORM\OneToMany(mappedBy: 'favorites', targetEntity: Property::class)]
    private Collection $idProperty;

    public function __construct()
    {
        $this->idProperty = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getIdProperty(): Collection
    {
        return $this->idProperty;
    }

    public function addIdProperty(Property $idProperty): static
    {
        if (!$this->idProperty->contains($idProperty)) {
            $this->idProperty->add($idProperty);
            $idProperty->setFavorites($this);
        }

        return $this;
    }

    public function removeIdProperty(Property $idProperty): static
    {
        if ($this->idProperty->removeElement($idProperty)) {
            // set the owning side to null (unless already changed)
            if ($idProperty->getFavorites() === $this) {
                $idProperty->setFavorites(null);
            }
        }

        return $this;
    }
}
