<?php

namespace App\Entity;

use App\Repository\CarrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrierRepository::class)]
class Carrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'carrier', targetEntity: NumberPlate::class)]
    private Collection $numberPlates;

    #[ORM\OneToMany(mappedBy: 'carrier', targetEntity: Extraction::class)]
    private Collection $extractions;

    public function __construct()
    {
        $this->numberPlates = new ArrayCollection();
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
     * @return Collection<int, NumberPlate>
     */
    public function getNumberPlates(): Collection
    {
        return $this->numberPlates;
    }

    public function addNumberPlate(NumberPlate $numberPlate): self
    {
        if (!$this->numberPlates->contains($numberPlate)) {
            $this->numberPlates->add($numberPlate);
            $numberPlate->setCarrier($this);
        }

        return $this;
    }

    public function removeNumberPlate(NumberPlate $numberPlate): self
    {
        if ($this->numberPlates->removeElement($numberPlate)) {
            // set the owning side to null (unless already changed)
            if ($numberPlate->getCarrier() === $this) {
                $numberPlate->setCarrier(null);
            }
        }

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
            $extraction->setCarrier($this);
        }

        return $this;
    }

    public function removeExtraction(Extraction $extraction): self
    {
        if ($this->extractions->removeElement($extraction)) {
            // set the owning side to null (unless already changed)
            if ($extraction->getCarrier() === $this) {
                $extraction->setCarrier(null);
            }
        }

        return $this;
    }
}
