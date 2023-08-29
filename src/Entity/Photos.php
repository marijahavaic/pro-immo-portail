<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotosRepository::class)]
class Photos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Path = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Property $idProperty = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->Path;
    }

    public function setPath(string $Path): static
    {
        $this->Path = $Path;

        return $this;
    }

    public function getIdProperty(): ?Property
    {
        return $this->idProperty;
    }

    public function setIdProperty(?Property $idProperty): static
    {
        $this->idProperty = $idProperty;

        return $this;
    }
}
