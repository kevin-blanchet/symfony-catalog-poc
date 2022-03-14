<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductTypeRepository::class)]
#[ApiResource(
    collectionOperations: ['get']
    , itemOperations: ['get']
)]
class ProductType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $productTypeName;

    #[ORM\OneToMany(mappedBy: 'productType', targetEntity: Product::class)]
    private $products;

    #[ORM\ManyToMany(targetEntity: OptionType::class, inversedBy: 'productTypes')]
    private $optionTypes;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->optionTypes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->productTypeName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductTypeName(): ?string
    {
        return $this->productTypeName;
    }

    public function setProductTypeName(string $productTypeName): self
    {
        $this->productTypeName = $productTypeName;

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
            $product->setProductType($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getProductType() === $this) {
                $product->setProductType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OptionType>
     */
    public function getOptionTypes(): Collection
    {
        return $this->optionTypes;
    }

    public function addOptionType(OptionType $optionType): self
    {
        if (!$this->optionTypes->contains($optionType)) {
            $this->optionTypes[] = $optionType;
        }

        return $this;
    }

    public function removeOptionType(OptionType $optionType): self
    {
        $this->optionTypes->removeElement($optionType);

        return $this;
    }
}
