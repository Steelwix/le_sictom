<?php

namespace App\Entity;

use App\Repository\FrequentationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FrequentationRepository::class)]
class Frequentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'frequentation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $landfill = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $day = null;

    #[ORM\Column]
    private ?int $morningCount = null;

    #[ORM\Column]
    private ?int $afternoonCount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLandfill(): ?User
    {
        return $this->landfill;
    }

    public function setLandfill(User $landfill): self
    {
        $this->landfill = $landfill;

        return $this;
    }

    public function getDay(): ?\DateTimeInterface
    {
        return $this->day;
    }

    public function setDay(\DateTimeInterface $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getMorningCount(): ?int
    {
        return $this->morningCount;
    }

    public function setMorningCount(int $morningCount): self
    {
        $this->morningCount = $morningCount;

        return $this;
    }

    public function getAfternoonCount(): ?int
    {
        return $this->afternoonCount;
    }

    public function setAfternoonCount(int $afternoonCount): self
    {
        $this->afternoonCount = $afternoonCount;

        return $this;
    }
}
