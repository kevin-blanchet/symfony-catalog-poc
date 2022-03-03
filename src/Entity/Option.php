<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
#[ApiResource]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $optionName;

    #[ORM\ManyToOne(targetEntity: OptionType::class, inversedBy: 'options')]
    #[ORM\JoinColumn(nullable: false)]
    private $optionType;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'options')]
    private $products;

    #[ORM\Column(type: 'integer')]
    private $asort;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->optionName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOptionName(): ?string
    {
        return $this->optionName;
    }

    public function setOptionName(string $optionName): self
    {
        $this->optionName = $optionName;

        return $this;
    }

    public function getOptionType(): ?OptionType
    {
        return $this->optionType;
    }

    public function setOptionType(?OptionType $optionType): self
    {
        $this->optionType = $optionType;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addOption($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeOption($this);
        }

        return $this;
    }

    public function getAsort(): ?int
    {
        return $this->asort;
    }

    public function setAsort(int $asort): self
    {
        $this->asort = $asort;

        return $this;
    }
}
