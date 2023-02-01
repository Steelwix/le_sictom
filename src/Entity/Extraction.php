<?php

namespace App\Entity;

use App\Repository\ExtractionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExtractionRepository::class)]
class Extraction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'extractions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $landfill = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datetime = null;

    #[ORM\ManyToOne(inversedBy: 'extractions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Material $material = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column]
    private ?string $size = null;

    #[ORM\ManyToOne(inversedBy: 'extractions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Carrier $carrier = null;

    #[ORM\ManyToOne(inversedBy: 'extractions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?NumberPlate $numberPlate = null;

    #[ORM\Column(length: 255)]
    private ?string $destination = null;

    #[ORM\Column]
    private ?bool $isEmergency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLandfill(): ?User
    {
        return $this->landfill;
    }

    public function setLandfill(?User $landfill): self
    {
        $this->landfill = $landfill;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

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

    public function getNumberPlate(): ?NumberPlate
    {
        return $this->numberPlate;
    }

    public function setNumberPlate(?NumberPlate $numberPlate): self
    {
        $this->numberPlate = $numberPlate;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function isIsEmergency(): ?bool
    {
        return $this->isEmergency;
    }

    public function setIsEmergency(bool $isEmergency): self
    {
        $this->isEmergency = $isEmergency;

        return $this;
    }
}
