<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Repository\OptionRepository;
use App\Repository\OptionTypeRepository;
use App\Repository\ProductTypeRepository;
use App\Repository\TagRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private $optionTypeRepository;
    private $productTypeRepository;
    private $optionRepository;
    private $tagRepository;

    public function __construct(OptionTypeRepository $optionTypeRepository, ProductTypeRepository $productTypeRepository, OptionRepository $optionRepository, TagRepository $tagRepository)
    {
        $this->optionTypeRepository = $optionTypeRepository;
        $this->productTypeRepository = $productTypeRepository;
        $this->optionRepository = $optionRepository;
        $this->tagRepository = $tagRepository;
    }

    public function load(ObjectManager $manager)
    {
        $productTypes = [
            "shoe" => $this->productTypeRepository->findOneBy(["productTypeName" => "shoe"])
            , "tshirt" => $this->productTypeRepository->findOneBy(["productTypeName" => "tshirt"])
        ];
        $optionTypes = [
            "shoe_size" => $this->optionTypeRepository->findOneBy(["optionTypeName" => "shoe_size"])
            , "eu_size" => $this->optionTypeRepository->findOneBy(["optionTypeName" => "eu_size"])
        ];

        $allShoeOptions = $this->optionRepository->findBy(["optionType" => $optionTypes["shoe_size"]]);
        $allTshirtOptions = $this->optionRepository->findBy(["optionType" => $optionTypes["eu_size"]]);
        $allTags = $this->tagRepository->findAll();

        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setProductName('Shoes '.$i);
            $product->setProductPrice(rand(20, 100) * 100);
            $product->setProductType($productTypes["shoe"]);
            $twoTags = array_rand($allTags, 2);
            $product->addTag($allTags[$twoTags[0]]);
            $product->addTag($allTags[$twoTags[1]]);
            foreach ($allShoeOptions as $v){
                $product->addOption($v);
            }
            $manager->persist($product);
        }

        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setProductName('tshirt '.$i);
            $product->setProductPrice(rand(5, 50) * 100);
            $product->setProductType($productTypes["tshirt"]);
            $twoTags = array_rand($allTags, 2);
            $product->addTag($allTags[$twoTags[0]]);
            $product->addTag($allTags[$twoTags[1]]);
            foreach ($allTshirtOptions as $v){
                $product->addOption($v);
            }
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OptionTypeFixtures::class
            , OptionFixtures::class
            , TagFixtures::class
            , ProductTypeFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['group5'];
    }
}