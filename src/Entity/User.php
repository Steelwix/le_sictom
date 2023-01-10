<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?bool $isLandfill = null;

    #[ORM\OneToOne(mappedBy: 'landfill', cascade: ['persist', 'remove'])]
    private ?Frequentation $frequentation = null;

    #[ORM\OneToMany(mappedBy: 'landfill', targetEntity: Extraction::class)]
    private Collection $extractions;

    public function __construct()
    {
        $this->extractions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isIsLandfill(): ?bool
    {
        return $this->isLandfill;
    }

    public function setIsLandfill(bool $isLandfill): self
    {
        $this->isLandfill = $isLandfill;

        return $this;
    }

    public function getFrequentation(): ?Frequentation
    {
        return $this->frequentation;
    }

    public function setFrequentation(Frequentation $frequentation): self
    {
        // set the owning side of the relation if necessary
        if ($frequentation->getLandfill() !== $this) {
            $frequentation->setLandfill($this);
        }

        $this->frequentation = $frequentation;

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
            $extraction->setLandfill($this);
        }

        return $this;
    }

    public function removeExtraction(Extraction $extraction): self
    {
        if ($this->extractions->removeElement($extraction)) {
            // set the owning side to null (unless already changed)
            if ($extraction->getLandfill() === $this) {
                $extraction->setLandfill(null);
            }
        }

        return $this;
    }
}
