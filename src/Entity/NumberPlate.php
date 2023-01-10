<?php

namespace App\Entity;

use App\Repository\NumberPlateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NumberPlateRepository::class)]
class NumberPlate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\ManyToOne(inversedBy: 'numberPlates')]
    private ?Carrier $carrier = null;

    #[ORM\OneToMany(mappedBy: 'numberPlate', targetEntity: Extraction::class)]
    private Collection $extractions;

    public function __construct()
    {
        $this->extractions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getCarrier(): ?Carrier
    {
        return $this->carrier;
    }

    public function setCarrier(?Carrier $carrier): self
    {
        $this->carrier = $carrier;

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
            $extraction->setNumberPlate($this);
        }

        return $this;
    }

    public function removeExtraction(Extraction $extraction): self
    {
        if ($this->extractions->removeElement($extraction)) {
            // set the owning side to null (unless already changed)
            if ($extraction->getNumberPlate() === $this) {
                $extraction->setNumberPlate(null);
            }
        }

        return $this;
    }
}
