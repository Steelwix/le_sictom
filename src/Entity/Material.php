<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: Extraction::class)]
    private Collection $extractions;

    public function __construct()
    {
        $this->extractions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Extraction>
     */
    public function getExtractions(): Collection
    {
        return $this->extractions;
    }

    public function addExtraction(Extraction $extraction): self
    {
        if (!$this->extractions->contains($extraction)) {
            $this->extractions->add($extraction);
            $extraction->setMaterial($this);
        }

        return $this;
    }

    public function removeExtraction(Extraction $extraction): self
    {
        if ($this->extractions->removeElement($extraction)) {
            // set the owning side to null (unless already changed)
            if ($extraction->getMaterial() === $this) {
                $extraction->setMaterial(null);
            }
        }

        return $this;
    }
}
