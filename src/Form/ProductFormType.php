<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductType;
use App\Repository\OptionRepository;
use App\Repository\OptionTypeRepository;
use App\Repository\ProductTypeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFormType extends AbstractType
{
    private OptionRepository $optionRepository;
    private OptionTypeRepository $optionTypeRepository;
    private ProductTypeRepository $productTypeRepository;
    public function __construct(OptionRepository $optionRepository, OptionTypeRepository $optionTypeRepository, ProductTypeRepository $productTypeRepository)
    {
        $this->optionRepository = $optionRepository;
        $this->optionTypeRepository = $optionTypeRepository;
        $this->productTypeRepository = $productTypeRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Product|null $product */
        $product = $options['data'] ?? null;
        $productType = $product?->getProductType();

        $builder
            ->add('productName')
            ->add('productPrice')
            ->add('productType')
            ->add('tags')
        ;
        if($productType)
        {
            $choices = $this->getOptionChoices($productType);
            $builder->add('options', null, [
                'placeholder' => 'Size, colors, etc.',
                'choices' => $choices,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

    private function getOptionChoices(ProductType $productType): array
    {
        $optionTypes = $this->optionTypeRepository->findByProductTypeId($productType->getId());
        $returnArray = [];

        foreach ($optionTypes as $optionType) {
            $returnArray[$optionType->getOptionTypeName()] = $this->optionRepository->findBy(["optionType" => $optionType]);
        }
        return $returnArray;
    }
}
