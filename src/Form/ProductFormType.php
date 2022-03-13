<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductType;
use App\Repository\OptionRepository;
use App\Repository\OptionTypeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFormType extends AbstractType
{
    private OptionRepository $optionRepository;
    private OptionTypeRepository $optionTypeRepository;
    public function __construct(OptionRepository $optionRepository, OptionTypeRepository $optionTypeRepository)
    {
        $this->optionRepository = $optionRepository;
        $this->optionTypeRepository = $optionTypeRepository;
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
        $builder->get('productType')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event){
                $form = $event->getForm();
                $this->setupOptionsField($form->getParent(), $form->getData());
            }
        );
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

    private function setupOptionsField(FormInterface $formInterface, ?ProductType $productType)
    {
        if ($productType === null){
            $formInterface->remove('options');
            return;
        }

        $options = $this->getOptionChoices($productType);

        if (empty($options)){
            $formInterface->remove('options');
            return;
        }
        $formInterface->add('options', null, [
            'placeholder' => 'Size, colors, etc.',
            'choices' => $options,
        ]);
    }
}
