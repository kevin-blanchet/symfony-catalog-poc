<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OptionTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionTypeRepository::class)]
#[ApiResource(
    collectionOperations: ['get']
    , itemOperations: ['get']
)]
class OptionType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $optionTypeName;

    #[ORM\OneToMany(mappedBy: 'optionType', targetEntity: Option::class)]
    private $options;

    #[ORM\ManyToMany(targetEntity: ProductType::class, mappedBy: 'optionTypes')]
    private $productTypes;

    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->productTypes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->optionTypeName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOptionTypeName(): ?string
    {
        return $this->optionTypeName;
    }

    public function setOptionTypeName(string $optionTypeName): self
    {
        $this->optionTypeName = $optionTypeName;

        return $this;
    }

    /**
     * @return Collection<int, Option>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setOptionType($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getOptionType() === $this) {
                $option->setOptionType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductType>
     */
    public function getProductTypes(): Collection
    {
        return $this->productTypes;
    }

    public function addProductType(ProductType $productType): self
    {
        if (!$this->productTypes->contains($productType)) {
            $this->productTypes[] = $productType;
            $productType->addOptionType($this);
        }

        return $this;
    }

    public function removeProductType(ProductType $productType): self
    {
        if ($this->productTypes->removeElement($productType)) {
            $productType->removeOptionType($this);
        }

        return $this;
    }
}
