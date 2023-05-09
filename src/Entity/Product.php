<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['products:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['products:read'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['products:read'])]
    private ?bool $visible = true;

    #[ORM\Column]
    #[Groups(['products:read'])]
    private ?bool $discount = false;

    #[ORM\Column]
    #[Groups(['products:read'])]
    private ?float $taxFreePrice = null;

    #[ORM\ManyToOne(inversedBy: 'Products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['products:read'])]
    private ?Category $category = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['products:read'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['products:read'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'])]
    private ?\DateTimeInterface $dateCreated = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['products:read'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function isDiscount(): ?bool
    {
        return $this->discount;
    }

    public function setDiscount(bool $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getTaxFreePrice(): ?float
    {
        return $this->taxFreePrice;
    }

    public function setTaxFreePrice(float $taxFreePrice): self
    {
        $this->taxFreePrice = $taxFreePrice;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
