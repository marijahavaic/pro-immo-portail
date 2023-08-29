<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favorite')]
    private Collection $user;

    #[ORM\ManyToMany(targetEntity: Property::class, inversedBy: 'favorite')]
    private Collection $property;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->property = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperty(): Collection
    {
        return $this->property;
    }

    public function addProperty(Property $property): static
    {
        if (!$this->property->contains($property)) {
            $this->property->add($property);
        }

        return $this;
    }

    public function removeProperty(Property $property): static
    {
        $this->property->removeElement($property);

        return $this;
    }
}
